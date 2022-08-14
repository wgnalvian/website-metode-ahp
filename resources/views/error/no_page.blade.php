@include('layout.header')
  <div class="container-fluid">

                    <!-- 404 Error Text -->
                    <div class="text-center">
                        <div class="error1 mx-auto" data-text="404">404</div>
                        <p class="lead text-gray-800 mb-5">Page Not Found</p>
                      
                        <a href="{{url()->previous()}}">&larr; Back to Previous</a>
                    </div>

                </div>
@include('layout.footer')