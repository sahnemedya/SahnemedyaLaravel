@yield("extraJs")
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script>

    const notyf = new Notyf({
        duration: 3000,
        ripple: true,
        dismissible: true,
        position: {
            x: 'right',
            y: 'top',
        },
        types: [
            {
                type: 'warning',
                background: 'orange',
                icon: {
                    className: 'fas fa-exclamation-triangle',
                    tagName: 'i',
                }
            },
            {
                type: 'info',
                background: '#3f87f5',
                icon: {
                    className: 'fas fa-info-circle',
                    tagName: 'i',
                }
            }
        ]
    });

    @if(session('status')==="success")
    notyf.success("{{ session('message') }}");
    @endif

    @if(session('status')==="error")
    notyf.error("{{ session('message') }}");
    @endif

    @php
        // notyf.open({
        //     type: 'warning',
        //     message: 'Dikkat! Bu işlem geri alınamaz.'
        // });
    @endphp
</script>
</body>
</html>
