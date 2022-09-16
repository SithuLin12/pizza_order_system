@extends("user.layout.master")

@section("content")



    <!-- Cart Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th></th>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($cart as$c )
                        <tr>
                            {{-- <input type="hidden" name="" value="{{ $c->product_price }}" id="price"> --}}
                            <td class="align-middle"><img src="{{ asset("storage/".$c->product_image) }}" class="img-thumbnail shadow-sm" alt="" style="width: 100px;"></td>
                            <td><input type="hidden" name="" value="{{ $c->id }}" id="orderId"></td>
                            <td><input type="hidden" value="{{ $c->product_id }}" id="productId"></td>
                            <td><input type="hidden" value="{{ Auth::user()->id }}" id="userId"></td>
                            <td class="align-middle">{{ $c->product_name }}</td>
                            <td class="align-middle" id="pizzaPrice">{{ $c->product_price }} Kyats</td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-warning btn-minus" >
                                        <i class="fa fa-minus text-white"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm  border-0 text-center" value="{{ $c->qty }}" id="qty">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-warning btn-plus">
                                            <i class="fa fa-plus text-white"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle col-3" id="total">{{ $c->product_price * $c->qty }} Kyats</td>
                            <td class="align-middle"><button class="btn btn-sm btn-danger btn-remove"><i class="fa fa-times"></i></button></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <h5 class="section-title position-relative text-uppercase mb-3"><span class=" pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6 >Subtotal</h6>
                            <h6 id="subTotalPrice">{{ $totalPrice }} Kyats</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Delivery</h6>
                            <h6 class="font-weight-medium">3000 Kyats</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5 id="finalPrice">{{ $totalPrice + 3000 }} Kyats</h5>
                        </div>
                        <button class="btn btn btn-warning w-100 font-weight-bold my-3 py-3" id="orderBtn">
                            <span class="text-dark">Proceed To Checkout</span>
                        </button>
                        <button class="btn btn btn-danger w-100 font-weight-bold my-3 py-3" id="clearBtn">
                            <span class="text-white">Clear Cart</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section("scriptSource")
<script>
    // when + button click
    $(document).ready(function(){
       $(".btn-plus").click(function(){
           $parentNote = $(this).parents("tr");
           $price = Number($parentNote.find("#pizzaPrice").text().replace("Kyats",""));
           $qty = Number($parentNote.find("#qty").val());
           $total = $qty * $price;
           $parentNote.find("#total").html($total +""+ "Kyats") ;

            summaryCalculation()

       })

        // when - buttom click
       $(".btn-minus").click(function(){
        $parentNote = $(this).parents("tr");
        $price = Number($parentNote.find("#pizzaPrice").text().replace("Kyats",""));
           $qty = Number($parentNote.find("#qty").val());
           $total = $qty * $price;
           $parentNote.find("#total").html($total +""+ "Kyats") ;

           summaryCalculation();
       })

        //when cross buttom click


       function summaryCalculation(){
        $totalPrice = 0;
        $("#dataTable tr").each(function(index,row){
                 $totalPrice += Number($(row).find("#total").text().replace("Kyats",""));
           });

           $("#subTotalPrice").html(`${$totalPrice} Kyats`)
           $("#finalPrice").html(`${$totalPrice+3000} Kyats`)
       }

       $("#orderBtn").click(function(){
            $orderList = [];

            $rand = Math.floor(Math.random() * 10000000001)

            $("#dataTable tbody tr").each(function(index,row){
                $orderList.push({
                    "user_id" : $(row).find("#userId").val(),
                    "product_id" :$(row).find("#productId").val(),
                    "qty" : $(row).find("#qty").val(),
                    "total" : $(row).find("#total").text().replace("Kyats","")*1,
                    "order_code" : "POS"+ $rand
                })
            })

            $.ajax({
                type: "get",
                url : "http://localhost:8000/user/ajax/order",
                data : Object.assign({},$orderList),
                dataType : "json",
                success: function(response){
                    if(response.status == "success"){
                       window.location.href="http://localhost:8000/user/home"
                    }
                }
            })
       })


    })

    $("#clearBtn").click(function(){
       $("#dataTable tbody tr").remove();
       $("#subTotalPrice").html("0 Kyat")
       $("#finalPrice").html("3000 Kyats")

       $.ajax({
            type: "get",
            url: "http://localhost:8000/user/ajax/clear/cart",
            dataType : "json",
       })
    })

    $(".btn-remove").click(function(){
        $parentNote = $(this).parents("tr");
        $productId  = $parentNote.find("#productId").val()
        $orderId  = $parentNote.find("#orderId").val()

        $.ajax({
            type: "get",
            url : "http://localhost:8000/user/ajax/clear/row/cart",
            data : {"productId" : $productId,"orderId" : $orderId},
            dataType : "json",
        })

         $parentNote.remove();

         $totalPrice = 0;
        $("#dataTable tr").each(function(index,row){
                 $totalPrice += Number($(row).find("#total").text().replace("Kyats",""));
           });

           $("#subTotalPrice").html(`${$totalPrice} Kyats`)
           $("#finalPrice").html(`${$totalPrice+3000} Kyats`)
       })


</script>
@endsection
