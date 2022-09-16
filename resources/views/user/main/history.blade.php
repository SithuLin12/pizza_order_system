@extends("user.layout.master")

@section("content")
    <!-- Cart Start -->
    <div class="container-fluid" style="height: 400px;">
        <div class="row px-xl-5">
            <div class="col-lg-8 offset-2 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date</th>
                            <th>Order ID</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">

                            @foreach ($order as $c)
                            <tr>
                            <td class="align-middle">{{ $c->created_at->format("F-j-Y") }}</td>
                            <td class="align-middle">{{ $c->order_code }}</td>
                            <td class="align-middle">{{ $c->total_price }}</td>
                            <td class="align-middle">
                                @if ($c->status == 0)
                                    <span class="text-warning"> <i class="fa-regular fa-clock me-2"></i>pending...</span>
                                @elseif($c->status == 1)
                                    <span class="text-success"><i class="fa-solid fa-check me-2"></i>success...</span>
                                @elseif($c->status == 2)
                                    <span class="text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i>reject...</span>
                                @endif
                            </td>
                            </tr>
                            @endforeach

                    </tbody>
                </table>
                <div class="mt-4">{{ $order->links() }}</div>
            </div>

        </div>
    </div>
    <!-- Cart End -->
@endsection


