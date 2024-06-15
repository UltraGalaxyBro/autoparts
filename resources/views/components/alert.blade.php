@if (session('success'))
    <script>
        window.addEventListener('load', () => {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                iconColor: "white",
                customClass: {
                    popup: "colored-toast",
                },
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: "success",
                title: "Pronto!",
                text: "{{ session('success') }}"
            });
        });
    </script>
@endif

@if (session('error'))
    <script>
        window.addEventListener('load', () => {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                iconColor: "white",
                customClass: {
                    popup: "colored-toast",
                },
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: "error",
                title: "Ops...",
                text: "{{ session('error') }}"
            });
        });
    </script>
@endif

@if (session('warning'))
    <script>
        window.addEventListener('load', () => {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                iconColor: "white",
                customClass: {
                    popup: "colored-toast",
                },
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: "warning",
                title: "Atenção!",
                text: "{{ session('warning') }}"
            });
        });
    </script>
@endif

@if (session('info'))
    <script>
        window.addEventListener('load', () => {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                iconColor: "white",
                customClass: {
                    popup: "colored-toast",
                },
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: "info",
                title: "Uma novidade!",
                text: "{{ session('info') }}"
            });
        });
    </script>
@endif

@if (session('question'))
    <script>
        window.addEventListener('load', () => {
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                iconColor: "white",
                customClass: {
                    popup: "colored-toast",
                },
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
            });

            Toast.fire({
                icon: "question",
                title: "Pergunta séria!",
                text: "{{ session('question') }}"
            });
        });
    </script>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            window.addEventListener('load', () => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "center",
                    iconColor: "white",
                    customClass: {
                        popup: "colored-toast",
                    },
                    showConfirmButton: true,
                });

                Toast.fire({
                    icon: "error",
                    title: "Ops...",
                    text: "{{ $error }}"
                });
            });
        </script>
    @endforeach
@endif
