
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
                            <div class="">
                                <i class="fa-solid fa-arrow-left ms-5" onclick="history.back()"></i>
                            </div>
                            <div class="card-title">
                                <h3 class="text-center title-2">Edit Pizza</h3>
                            </div>
                            <form action="{{ route("product#update",$pizza->id )}}"  method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row mt-2">
                                    <div class="col-4 offset-1">
                                        <img class="img-thumbnail" src="{{ asset("storage/".$pizza->image) }}" >

                                        <div class="mt-3">
                                            <input type="file" name="pizzaImage" id="" class="form-control @error('pizzaImage') is-invalid @enderror">
                                            @error('pizzaImage')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="mt-3">
                                            <button type="submit" class="btn bg-dark text-white col-12"><i class="fa-solid fa-angles-up me-2"></i>Update</button>
                                        </div>
                                    </div>
                                    <div class="row col-6">
                                        <div class="form-group">
                                            <label  class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="pizzaName" type="text" placeholder="Enter pizza Name" value="{{ old("pizzaName",$pizza->name) }}"  class="form-control @error('pizzaName') is-invalid @enderror" aria-required="true" aria-invalid="false" >
                                            @error('pizzaName')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1">Description</label>
                                            <textarea name="pizzaDescription" id="" class="form-control @error('pizzaDescription') is-invalid @enderror" cols="30"  rows="10" placeholder="Enter pizza Details">{{ old("pizzaDescription",$pizza->description) }}</textarea>
                                            @error('pizzaDescription')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1">Category</label>
                                            <select name="pizzaCategory" class="form-control @error('pizzaCategory') is-invalid @enderror">
                                                <option value="">Choose your Category</option>
                                                @foreach ($categories as $c )
                                                    <option value="{{ $c->id }}" @if($pizza->category_id == $c->id) selected @endif>{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('gender')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1">Price</label>
                                            <input type="hidden" name="pizzaId" value="{{ $pizza->id }}">
                                            <input id="cc-pament" name="pizzaPrice" type="number" value="{{ old("pizzaPrice",$pizza->price) }}"  class="form-control @error('pizzaPrice') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter your price...">
                                            @error('pizzaPrice')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1">Waiting Time</label>
                                            <input id="cc-pament" name="pizzaWaitingTime" type="number" value="{{ old("pizzaWaitingTime",$pizza->waiting_time) }}"   class="form-control @error('pizzaWaitingTime') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter your waiting time...">
                                            @error('pizzaWaitingTime')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1">View Count</label>
                                            <input id="cc-pament" name="view_count" type="number" value="{{ old("view_count",$pizza->view_count) }}" disabled  class="form-control " aria-required="true" aria-invalid="false" >
                                        </div>

                                        <div class="form-group">
                                            <label  class="control-label mb-1">Date</label>
                                            <input type="text" name="create_at" class="form-control" value="{{ old("create_at",$pizza->created_at->format("j-F-Y")) }}" id="" disabled>
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
