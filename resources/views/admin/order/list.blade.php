@extends('admin.layouts.master')

@section('title', 'categoryListPage')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Order List</h2>

                            </div>
                        </div>
                        <div class="table-data__tool-right">

                            <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                CSV download
                            </button>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-3">
                            <h4 class="text-muted">Search Key: <span class="text-danger">{{ request('key') }}</span></h4>
                        </div>
                        <div class="col-3 offset-9">
                            <form action="{{ route('admin#orderList') }}" method="GET">
                                <div class="input-group">
                                    <input type="search" name="key" value="{{ request('key') }}" class="form-control"
                                        placeholder="Search Order Code..">
                                    <button class="btn btn-danger"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-1 offset-10 bg-white shadow-sm py-1 px-2 my-1 text-center">
                            <h3><i class="fa-solid fa-database me-2"></i>{{ count($order) }}</h3>
                        </div>
                    </div>

                    <form action="{{ route("order#changeStatus") }}" method="GET">
                        @csrf
                        <div class="input-group my-3">
                            <button  disabled class="btn bg-dark text-white me-2"><i class="fa-solid fa-database me-2"></i>{{ count($order) }}</button>
                                <select name="orderStauts" id="orderStatus" class="form-control col-2" id="">
                                    <option value="">All</option>
                                    <option value="0" @if(request("orderStauts") == "0") selected  @endif>Pending</option>
                                    <option value="1" @if(request("orderStauts") == "1") selected @endif>Accept</option>
                                    <option value="2" @if(request("orderStauts") == "2") selected @endif>Reject</option>
                                </select>
                            <button type="submit" class="btn btn-dark">Search</button>
                        </div>
                    </form>

                    @if (count($order) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>Order Data</th>
                                        <th>Order Code</th>
                                        <th>Account</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="dataList">
                                    @foreach ($order as $o)
                                        <tr class="tr-shadow">
                                            <input type="hidden" class="orderId" value="{{ $o->id }}">
                                            <td class="">{{ $o->user_id }}</td>
                                            <td>{{ $o->user_name }}</td>
                                            <td>{{ $o->created_at->format('j-F-Y') }}</td>
                                            <td>
                                                <a href="{{ route("admin#listInfo",$o->order_code) }}">
                                                {{ $o->order_code }}
                                                </a>
                                            </td>
                                            <td>{{ $o->total_price }} Kyats</td>
                                            <td>
                                                <select name="status" class="form-control statusChange" id="">
                                                    <option value="0"
                                                        @if ($o->status == 0) selected @endif>Pending</option>
                                                    <option value="1"
                                                        @if ($o->status == 1) selected @endif>Accept</option>
                                                    <option value="2"
                                                        @if ($o->status == 2) selected @endif>Reject</option>
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="">
                                {{-- {{ $order->appends(request()->query())->links() }} --}}
                            </div>
                        </div>
                    @else
                        <h4 class="mt-5 text-center">There is no order here...</h4>
                    @endif
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

@section('source')
    <script>
        $(document).ready(function() {


            $(".statusChange").change(function(){
                $currentStatus = $(this).val();
                $parentNote = $(this).parents("tr");
                $orderId = $parentNote.find(".orderId").val();

                $data = {
                    "status" : $currentStatus,
                    "orderId" : $orderId
                }
                $.ajax({
                    type: "get",
                    url: "http://localhost:8000/order/ajax/change/status",
                    data: $data,
                    dataType: "json",
                })
            })

        })
    </script>
@endsection
