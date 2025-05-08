<script>
    const Toast = Swal.mixin({
        toast: true, position: 'top-end', showConfirmButton: false, timer: 3000,
    });

    @foreach(['success', 'info', 'warning', 'error'] as $session)
        @if (session($session))
            Toast.fire({
                type: '{{ $session }}', title: '{{ session($session) }}',
            });
        @endif
    @endforeach
</script>
