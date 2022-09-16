@extends("user.layout.master")

@section("content")
    <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class=" pr-3">Filter by Categories</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="custom-control  d-flex align-items-center justify-content-between mb-3 bg-dark text-white px-3 py-2 mt-3">

                            <label class="" for="price-all">Categoreies</label>
                            <span class="badge border font-weight-normal">{{ count($categories) }}</span>

                        </div>
                        <div class="custom-control  d-flex align-items-center justify-content-between mb-3">
                            <a href="{{ route("user#home") }}" class="text-decoration-none text-dark">All</a>
                        </div>
                        @foreach ($categories as$c )

                        <div class="custom-control  d-flex align-items-center justify-content-between mb-3">
                            <a href="{{ route("user#filter",$c->id) }}" class="text-decoration-none text-dark">{{ $c->name }}</a>
                        </div>
                        @endforeach
                    </form>
                </div>
                <!-- Price End -->

                <div class="text-center">
                    <a href="{{ route("user#contactPage") }}">
                        <button class="btn btn btn-dark w-75">Contact Us</button>
                    </a>
                </div>

            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <a href="{{ route("cart#list") }} ">
                                    <button type="button" class="btn bg-dark text-white position-relative me-3">
                                        <i class="fa-solid fa-cart-plus"></i>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                            {{ count($cart) }}
                                        </span>
                                      </button>
                                </a>

                                <a href="{{ route("user#history") }}">
                                    <button type="button" class="btn bg-dark text-white position-relative">
                                        <i class="fa-solid fa-clock-rotate-left"></i>History
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                                {{ count($order) }}
                                        </span>
                                      </button>
                                </a>
                            </div>

                            <div class="">
                                @if (session("contactMessage"))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong><i class="fa-solid fa-circle-xmark me-2"></i>{{ session("contactMessage") }}</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-2">
                                <div class="btn-group">


                                    <select name="sorting" id="sortingOption" class="form-control">
                                        <option value="">Choose option</option>
                                        <option value="asc">Ascending</option>
                                        <option value="desc">Descending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                        <span class="row" id="dataList">
                            @if (count($pizza) != 0)
                            @foreach ($pizza as $p )
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1" id="myForm">
                                <div class="product-item bg-light mb-4">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100 " style="height: 250px" src="{{ asset("storage/".$p->image) }}" >
                                         <div class="product-action">
                                            <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                            <a class="btn btn-outline-dark btn-square" href="{{ route("user#pizzaDetails",$p->id) }}"><i class="fa-solid fa-circle-info"></i></a>
                                        </div>
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="">{{ $p->name }}</a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>{{ $p->price }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @else
                            <div class="text-center shadow-sm my-3 col-6 offset-3 ">
                                <h3 class="text-secondary py-3 my-3" >There is no Pizza<i class="fa-solid fa-pizza-slice ms-2"></i></h3>
                            </div>
                            @endif
                        </span>


                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->
@endsection


@section("scriptSource")
    <script>
        $(document).ready(function(){

            $("#sortingOption").change(function(){
                $eventOption = $("#sortingOption").val();
                console.log($eventOption);

                if($eventOption == "asc"){
                    $.ajax({
                        type: 'get',
                        url:  'http://localhost:8000/user/ajax/pizza/list',
                        data: {'status' : 'asc'},
                        dataType: 'json',
                        success: function(response){
                            $list = "";
                            for($i=0;$i<response.length;$i++){
                               $list += `

                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1" id="myForm">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100 " style="height: 250px" src="{{ asset('storage/${response[$i].image}') }}" >
                                     <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-circle-info"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>${response[$i].price}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                               `;
                            }
                            $('#dataList').html($list);
                        }
                    });
                }else if($eventOption == "desc"){
                    $.ajax({
                        type: 'get',
                        url:  'http://localhost:8000/user/ajax/pizza/list',
                        data: {'status' : 'desc'},
                        dataType: 'json',
                        success: function(response){
                            $list = "";
                            for($i=0;$i<response.length;$i++){
                               $list += `

                        <div class="col-lg-4 col-md-6 col-sm-6 pb-1" id="myForm">
                            <div class="product-item bg-light mb-4">
                                <div class="product-img position-relative overflow-hidden">
                                    <img class="img-fluid w-100 " style="height: 250px" src="{{ asset('storage/${response[$i].image}') }}" >
                                     <div class="product-action">
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-shopping-cart"></i></a>
                                        <a class="btn btn-outline-dark btn-square" href=""><i class="fa-solid fa-circle-info"></i></a>
                                    </div>
                                </div>
                                <div class="text-center py-4">
                                    <a class="h6 text-decoration-none text-truncate" href="">${response[$i].name}</a>
                                    <div class="d-flex align-items-center justify-content-center mt-2">
                                        <h5>${response[$i].price}</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                               `;
                            }
                            $('#dataList').html($list);
                        }
                    });
                }
            })
        })
    </script>
@endsection
