
@extends("admin.layouts.master")

@section("title","CategoryCreate")

@section("content")
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <a href="{{ route("admin#list") }}" class="text-dark text-decoration-none">
                                <i class="fa-solid fa-arrow-left-long"></i>  back
                            </a>
                            <div class="card-title">
                                <h3 class="text-center title-2">Change Role</h3>
                            </div>
                            <form action="{{ route("admin#updateChangeRole",$account->id) }}"  method="POST" >
                                @csrf
                                <div class="row mt-2">
                                    <div class="col-4 offset-1">
                                        @if ($account->image == null)
                                        @if ($account->gender == 'male')
                                                <img src="{{ asset("image/default_user.jpeg") }}" class="img-thumbnail shadow-sm" alt="">
                                            @else
                                                <img src="{{ asset("image/female_default.png") }}" class="img-thumbnail shadow-sm">
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/'.$account->image) }}" class="img-thumbnail shadow-sm"  />
                                        @endif

                                        <div class="mt-3">
                                            <button type="submit" class="btn bg-dark text-white col-12"><i class="fa-solid fa-angles-up me-2"></i>Update</button>
                                        </div>
                                    </div>
                                    <div class="row col-6">
                                        <div class="form-group">
                                            <label  class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="name" disabled type="text" value="{{ old("name",$account->name) }}"  class="form-control " aria-required="true" aria-invalid="false" placeholder="Enter your Name...">
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1">Role</label>
                                            <select name="role" id="" class="form-control">
                                                <option value="admin" @if($account->role == "admin") selected @endif >Admin</option>
                                                <option value="user" @if($account->role == "user") selected @endif >User</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1">Email</label>
                                            <input id="cc-pament" name="email" disabled type="text" value="{{ old("name",$account->email) }}"  class="form-control" aria-required="true" aria-invalid="false" placeholder="Enter your Email">
                                            @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1">Phone</label>
                                            <input id="cc-pament" name="phone" disabled type="number" value="{{ old("name",$account->phone) }}"  class="form-control " aria-required="true" aria-invalid="false" placeholder="09xxxxxx">
                                            @error('phone')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1">Gender</label>
                                            <select name="gender" disabled class="form-control" id="">
                                                <option value="">Choose Gender...</option>
                                                <option value="male" @if($account->gender == "male") selected @endif>Male</option>
                                                <option value="female" @if($account->gender == "female") selected @endif >Female</option>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1">Address</label>
                                            <textarea name="address" disabled class="form-control"  placeholder="Enter your address.."  cols="30" rows="10">{{ old("name",$account->address) }}</textarea>
                                        </div>


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
@endsection
