<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Config;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['title', 'slug', 'content', 'image', 'hit', 'category_id', 'parent_page', 'blade_id', 'translation_of', 'lang_id', 'published', 'is_main', 'show_homepage','show_footer',];

    /**
     * Sayfa resimlerinin bulunduğu klasör yolunu getirir.
     * @return string
     */
    public function getImagePath()
    {
        return asset('storage/' . Config::get('constants.page_path'));
    }

    /**
     * Sayfanın resmininin yolunu getirir. Eğer resim yoksa false değeri getirir.
     * @return false|string
     */
    public function image()
    {
        if ($this->image) {
            return asset("storage/" . config('constants.page_path') . "/" . $this->image); // Resmin tam URL'sini döndürüyor
        }
        return false;
    }

    /**
     * Sayfanın blade dosyasına ait ilişkiyi getirir.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blade()
    {
        return $this->belongsTo(Blade::class, 'blade_id');
    }

    /**
     * Sayfanın blade dosyasının view path'ini getirir.
     * @return false|string
     */
    public function bladePath()
    {
        if ($this->blade_id && $this->blade && $this->blade->file) {
            $fileName = str_replace('.blade.php', '', $this->blade->file);
            return 'user.blades.' . $fileName;
        }
        return false;
    }

    /**
     * Sayfanın blade dosyasının mevcut olup olmadığını kontrol eder.
     * @return bool
     */
    public function bladeExists()
    {
        $viewPath = $this->bladePath();
        return $viewPath && view()->exists($viewPath);
    }

    /**
     * Sayfanın blade dosyasının tam klasör yolunu getirir.
     * @return string
     */
    public function getBladePath()
    {
        return resource_path('views/user/blades/');
    }

    /**
     * Sayfanın galeri resimlerini getirir.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gallery()
    {
        return $this->hasMany(Gallery::class);
    }

    /**
     * Geçerli sayfanın üst sayfasını getirir.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_page');
    }

    /**
     * Geçerli sayfanın üst kategorisini getirir.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Bu sayfanın kategorinin ana sayfası olup olmadığını kontrol eder.
     * @return bool
     */
    public function isMainPageOfCategory(): bool
    {
        return $this->parentCategory &&
            $this->parentCategory->name === $this->title;
    }

    /**
     * Geçerli sayfanın breadcrumb listesini verir eğer sayfa alt sayfa olarak kaydedilmişse ust kategorinin breadcrumb listesini ekleyerek devam eder
     * @return \Illuminate\Support\Collection
     */
    public function breadcrumbs()
    {
        $breadcrumbs = collect();

        // Eğer üst sayfa varsa önce onu al
        if ($this->parent) {
            $breadcrumbs = $this->parent->breadcrumbs();
        }
        // Eğer üst sayfa yok ama bir kategoriye bağlıysa ve bu sayfa kategorinin ana sayfası değilse, kategori breadcrumblarını al
        elseif ($this->parentCategory && !$this->isMainPageOfCategory()) {
            $breadcrumbs = $this->parentCategory->breadcrumbs();
        }

        $breadcrumbs->push($this);

        return $breadcrumbs;
    }
    // SEO ilişkisi
    public function seo()
    {
        return $this->hasOne(Seo::class, 'page_id');
    }

    // Sadece GEO aktif sayfalar
    public function scopeWithGeo($query)
    {
        return $query->whereHas('seo', function($q) {
            $q->whereNotNull('geo_title')
                ->whereNotNull('geo_description')
                ->where('geo_title', '!=', '')
                ->where('geo_description', '!=', '');
        });
    }

    // Aktif sayfalar
//    public function scopeActive($query)
//    {
//        return $query->where('status', 'active');
//    }

    // GEO aktif mi kontrolü
    public function hasGeo(): bool
    {
        return $this->seo &&
            !empty($this->seo->geo_title) &&
            !empty($this->seo->geo_description);
    }
    /**
     * Geçerli sayfanın alt sayfalarını getirir.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Page::class, 'parent_page');
    }

    /**
     * Geçerli sayfanın tüm alt sayfalarını recursive olarak getirir.
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
    public function allChildrenBlog()
    {
        return $this->children()->with('allChildren')->orderBy('id', 'desc');
    }
    /**
     * Sayfanın hierarşi derinliğini hesaplar (LLMS.txt için # sayısı).
     * @return int
     */
    public function getDepth(): int
    {
        $depth = 1;
        $current = $this;

        while ($current->parent_page !== null && $current->parent_page !== 0) {
            $depth++;
            if ($current->parent) {
                $current = $current->parent;
            } else {
                break; // Parent yoksa döngüyü kır
            }

            // Sonsuz döngü koruması
            if ($depth > 10) break;
        }

        return $depth;
    }

    /**
     * LLMS.txt için sayfa bilgilerini optimize edilmiş formatta getirir.
     * @return array
     */
    public function getLlmsData(): array
    {
        if (!$this->hasGeo()) {
            return [];
        }

        return [
            'id' => $this->id,
            'title' => $this->seo->geo_title,
            'description' => $this->seo->geo_description,
            'slug' => $this->slug,
            'parent_page' => $this->parent_page,
            'depth' => $this->getDepth(),
            'updated_at' => $this->updated_at
        ];
    }
    /**
     * Model events - LLMS.txt otomatik güncelleme
     */
    protected static function boot()
    {
        parent::boot();

        // Sayfa kaydedildiğinde
        static::saved(function ($page) {
            // Sadece GEO aktif sayfalar için güncelle
            if ($page->hasGeo()) {
                try {
                    \Illuminate\Support\Facades\Artisan::call('geo:generate-llms-txt');
                    \Log::info('LLMS.txt güncellendi - Page saved: ' . $page->id);
                } catch (\Exception $e) {
                    \Log::error('LLMS.txt güncelleme hatası: ' . $e->getMessage());
                }
            }
        });

        // Sayfa silindiğinde
        static::deleted(function ($page) {
            try {
                \Illuminate\Support\Facades\Artisan::call('geo:generate-llms-txt');
                \Log::info('LLMS.txt güncellendi - Page deleted: ' . $page->id);
            } catch (\Exception $e) {
                \Log::error('LLMS.txt güncelleme hatası: ' . $e->getMessage());
            }
        });
    }
}
