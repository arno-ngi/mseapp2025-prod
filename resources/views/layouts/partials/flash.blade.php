<script>
    @auth
        alertify.defaults.notifier.position = '{{auth()->user()->notifier_position}}';
    @endauth
    @if(session()->has('flash_message'))
        @if(session('flash_message.level') === 'danger')
        alertify.error('{{ session('flash_message.message') }}')
        @elseif(session('flash_message.level') === 'success')
        alertify.success('{{ session('flash_message.message') }}')
        @else
        alertify.message('{{ session('flash_message.message') }}')
        @endif
    @endif
</script>
