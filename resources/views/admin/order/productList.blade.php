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
                        </div>
                    </div>
                    <a href="{{ route("admin#orderList") }}" class="text-decoration-none text-dark"><i class="fa-solid fa-arrow-left me-2"></i> back</a>
                    {{-- @if (count($order) != 0) --}}
                    <div class="row col-6">
                        <div class="card mt-2">
                            <div class="card-header">
                                <h3><i class="fa-solid fa-clipboard me-2"></i> Order Info</h3>
                                <small class="text-warning"><i class="fa-solid fa-triangle-exclamation me-2"></i>Include Delivery charges</small>
                            </div>
                            <div class="card-body">
                               <div class="row mb-3">
                                    <div class="col">
                                        <i class="fa-solid fa-user me-2"></i>Name
                                    </div>
                                    <div class="col">{{ strtoupper($orderList[0]->user_name) }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-barcode me-2"></i>Order Code</div>
                                    <div class="col">{{ $orderList[0]->order_code }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-clock me-2"></i> Order date</div>
                                    <div class="col">{{ $orderList[0]->created_at->format("j-F-Y") }}</div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col"><i class="fa-solid fa-money-bill-1-wave me-2."></i> Total</div>
                                    <div class="col">{{ $order->total_price }} Kyats</div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Order ID</th>
                                        <th>User Name</th>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>Order Date</th>
                                        <th>Qty</th>
                                        <th>Account</th>
                                    </tr>
                                </thead>
                                <tbody id="dataList">
                                    @foreach ($orderList as$o )
                                    <tr class="tr-shadow">
                                        <td></td>
                                        <td>{{ $o->id }}</td>
                                        <td>{{ $o->user_name }}</td>
                                        <td class="col-2">
                                            <img src="{{ asset("storage/".$o->product_image ) }}" >
                                        </td>
                                        <td>{{ $o->product_name }}</td>
                                        <td>{{ $o->created_at }}</td>
                                        <td>{{ $o->qty }}</td>
                                        <td>{{ $o->total }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <div class="">
                                {{-- {{ $order->appends(request()->query())->links() }} --}}
                            </div>
                        </div>
                    {{-- @else
                        <h4 class="mt-5 text-center">There is no pizza here...</h4>
                    @endif --}}
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection


