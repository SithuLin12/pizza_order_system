
@extends("admin.layouts.master")

@section("title","CategoryCreate")

@section("content")
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="row">
            <div class="col-3 offset-7">
                @if (session("updateSession"))
                <div class="">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong><i class="fa-solid fa-check me-2"></i>{{ session("updateSession") }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">

                        <div class="card-body">
                            <div class="">
                                {{-- <a href="{{ route("product#list") }}" class="text-decoration-none text-black">

                                </a> --}}
                                <i class="fa-solid fa-arrow-left ms-5" onclick="history.back()"></i>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2"></h3>
                            </div>

                            <hr>
                            <div class="row">
                                <div class="col-3 offset-2">
                                    <img class="img-thumbnail" src="{{ asset("storage/".$pizza->image) }}" alt="">
                                </div>
                                <div class="col-7 ">
                                    <div class="my-3 fs-5 btn bg-danger text-white d-block w-50 text-center">{{ $pizza->name }}</div>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fs-5  fa-money-bill-1-wave me-2"></i>{{ $pizza->price }} kyats</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fs-5  fa-clock me-2"></i>{{$pizza->waiting_time }} minute</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid  fs-5 fa-calendar-check me-2"></i>{{ $pizza->created_at->format("j-F-Y") }}</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fa-clone me-2"></i>{{ $pizza->category_name }}</span>
                                    <span class="my-3 btn bg-dark text-white"><i class="fa-solid fs-5  fa-eye me-2"></i>{{ $pizza->view_count }}</span>
                                    <div class="my-3"><i class="fa-solid  fs-5 fa-align-left me-2 "></i>Details</div>
                                    <div class="">
                                        {{ $pizza->description }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
