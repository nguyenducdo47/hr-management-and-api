<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Breeze Admin</title>
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="/assets/vendors/flag-icon-css/css/flag-icon.min.css" />
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css" />
    <link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="/assets/css/style.css" />
    <link rel="shortcut icon" href="/assets/images/favicon.png" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        setTimeout(function() {
            const alert = document.getElementById('alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000);
    </script>
</head>

<body class="text-capitalize">
    <div class="container-scroller">
        {{-- Side bar --}}
        @include('admin.partials.sidebar')

        <div class="container-fluid page-body-wrapper">
            {{-- Navbar --}}
            @include('admin.partials.navbar')


            <div class="main-panel">
                <div class="pb-0 content-wrapper">
                    <div class="row">
                        <header>
                            @yield('header')
                        </header>
                        @yield('content')
                        @if (session('success'))
                            <div id="alert" class="alert alert-success position-fixed" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div id="alert" class="alert alert-danger position-fixed" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>

                    @endif

                    </div>

                </div>

                {{-- Footer --}}
                @include('admin.partials.footer')
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="/assets/vendors/chart.js/Chart.min.js"></script>
    <script src="/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <script src="/assets/vendors/flot/jquery.flot.js"></script>
    <script src="/assets/vendors/flot/jquery.flot.resize.js"></script>
    <script src="/assets/vendors/flot/jquery.flot.categories.js"></script>
    <script src="/assets/vendors/flot/jquery.flot.fillbetween.js"></script>
    <script src="/assets/vendors/flot/jquery.flot.stack.js"></script>
    <script src="/assets/vendors/flot/jquery.flot.pie.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/hoverable-collapse.js"></script>
    <script src="/assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="/assets/js/dashboard.js"></script>
    <!-- End custom js for this page -->
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {
        $('#userTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "responsive": true,
            "columnDefs": [{
                    "orderable": false,
                    "targets": 4
                } // Disable ordering on the 'Actions' column
            ]
        });
    });
</script>

</html>
