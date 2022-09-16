@extends("user.layout.master")

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-6 offset-3">
                <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Contact Our Team</h3>
                            </div>
                            <hr>

                            <form action="{{ route("user#contact") }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="">Name</label>
                                        <input type="text" name="name" class="form-control @error("name") is-invalid @enderror" id="" placeholder="Enter your Name.....">
                                        @error("name")
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="col-12 mb-3">
                                        <label for="">Email</label>
                                        <input type="email" name="email" class="form-control  @error("email") is-invalid @enderror" id="" placeholder="Enter your Email address.....">
                                        @error("email")
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="">Message</label>
                                        <textarea name="message" class="form-control  @error("message") is-invalid @enderror" id="" cols="30" rows="10" placeholder="Enter the message"></textarea>
                                        @error("message")
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-6 offset-3 mb-3">
                                            <button class="btn btn-dark col-12" >Contact Us</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
            </div>
        </div>
    </div>
@endsection
