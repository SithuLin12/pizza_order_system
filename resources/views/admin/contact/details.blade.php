
@extends("admin.layouts.master")

@section("title","CategoryCreate")

@section("content")
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="row">
            <div class="col-3 offset-7">
            </div>
        </div>
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="">
                            <a href="{{ route("admin#contactList") }}" class="text-dark text-decoration-none"><i class="fa-solid fa-arrow-left me-2 ms-2"></i>back</a>
                        </div>
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Details</h3>
                            </div>

                            <hr>
                            <div class="row">
                                </div>
                                <div class="row">
                                    <div class="col-3 offset-2">
                                        <div class="mb-3 fw-bold"><i class="fa-solid fa-user me-2"></i>Name</div>
                                        <div class="mb-3 fw-bold"><i class="fa-solid fa-envelope me-2"></i>Email</div>
                                        <div class="mb-3 fw-bold"><i class="fa-solid fa-image-portrait me-2"></i>UserID</div>
                                        <div class="mb-3 fw-bold"><i class="fa-solid fa-clock me-2"></i>Date</div>
                                        <div class="mb-3 fw-bold"><i class="fa-solid fa-message me-2"></i>Message</div>
                                    </div>

                                    <div class="col">
                                        <h4 class="mb-4">{{ $contactDetails->name }}</h4>
                                        <h4 class="mb-4">{{ $contactDetails->email }}</h4>
                                        <h4 class="mb-4">{{ $contactDetails->user_id }}</h4>
                                        <h4 class="mb-4">{{ $contactDetails->created_at->format("j-F-Y") }}</h4>
                                        <div class="mb-4">{{ $contactDetails->message }}</div>
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
