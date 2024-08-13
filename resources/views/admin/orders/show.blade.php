@extends('admin.layouts.main')

@section('content')
    <div class="w-full px-8 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        @if($orders->isEmpty())
                            <p>No orders found.</p>
                        @else
                            <p class="font-bold">Order Number: {{ $orders[0]->order_number }}</p>
                        @endif
                    </div>
                    <div class="px-6 py-8">
                        <div class="container mx-auto">
                            <div id="articleContent" class="mb-4 mt-4">
                                <p class="mb-2 mt-2 font-bold">Reseller Name</p>
                                <p>{{ $orders[0]->reseller_name }}</p>
                                <p class="mb-2 mt-2 font-bold">No. Resi</p>
                                @if ($orders[0]->order_resi != null)
                                    <p>{{ $orders[0]->order_resi }}</p>
                                @else
                                    <p>None</p>
                                @endif
                                <p class="mb-2 mt-2 font-bold">Payment Status</p>
                                <p>{{ $orders[0]->order_payment }}</p>
                                <p class="mb-2 mt-2 font-bold">Order Status</p>
                                <p>{{ $orders[0]->order_status }}</p>
                                <p class="mb-2 mt-2 font-bold">Supplier Payment Status</p>
                                <p>{{ $orders[0]->supplier_payment_status }}</p>
                                <p class="mb-2 mt-2 font-bold">Products </p>
                                @foreach ($orders as $data)
                                <div class="mt-4 mb-4">
                                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl rounded-2xl bg-clip-border w-1/2 mb-4 hover:border-blue-500">
                                        <div class="flex-auto p-4">
                                        <div class="flex flex-wrap -mx-3">
                                            <div class="max-w-full px-3 lg:w-1/2 lg:flex-none">
                                            <div class="flex flex-col h-full">
                                                <h6 class="">{{ $data->product_name }}</h6>
                                                <p class="mt-auto mb-0 font-semibold leading-normal text-sm group text-slate-500">
                                                    {{ $data->supplier_name }}
                                                </p>
                                                <p class="mt-auto mb-0 font-semibold leading-normal text-sm group text-slate-500">
                                                    {{ $data->order_quantity }}x
                                                </p>
                                            </div>
                                            </div>
                                            <div class="max-w-full px-3 mt-12 ml-auto text-center lg:mt-0 lg:w-5/12 lg:flex-none">
                                            <div class="h-full rounded-xl">
                                                <img src="{{ asset('images') }}/{{ $data->product_image }}" class="absolute top-0 hidden w-1/2 h-full lg:block" alt="waves" />
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                @endforeach
                                <p class="mb-2 mt-2 font-bold">Total Price</p>
                                <p>{{ number_format($totalPrice->total_price) }}</p>
                                <p class="mb-2 mt-2 font-bold">Reseller Payment Image</p>
                                @if ($orders[0]->order_payment_image != null)
                                    <img src="{{ asset('images') }}/{{ $orders[0]->order_payment_image}}" class="w-1/2 h-full lg:block mb-2"/>
                                @else
                                    <p>No payment to admin has been made</p>
                                @endif
                                <p class="mb-2 mt-2 font-bold">Supplier Payment Proof</p>
                                @if ($orders[0]->admin_transfer_proof != null)
                                    <img src="{{ asset('storage/' . $orders[0]->admin_transfer_proof) }}" class="img-preview img-fluid mb-2 w-5/12 block">
                                @else
                                    <p>No payment to supplier has been made</p>
                                @endif
                                <div class="flex">
                                    @if ($orders[0]->order_payment == 'Pending')
                                    <form action="/admin/orders/{{ $orders[0]->order_number }}/approve" method="POST" class="mr-2">
                                        @csrf
                                        <button type="submit" class="px-6 py-3 mr-3 font-bold text-center text-white uppercase align-middle transition-all bg-emerald-500 rounded-lg cursor-pointer leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md mb-4 mt-2">Approve</button>
                                    </form>
                                    <form action="/admin/orders/{{ $orders[0]->order_number }}/reject" method="POST">
                                        @csrf
                                        <button type="submit" class="px-6 py-3 mr-3 font-bold text-center text-white uppercase align-middle transition-all bg-red-600 rounded-lg cursor-pointer leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md mb-4 mt-2">Reject</button>
                                    </form>
                                @else
                                    <a href="/admin/orders" class="inline-block px-6 py-3 mr-3 font-bold text-center text-white uppercase align-middle transition-all bg-blue-500 rounded-lg cursor-pointer leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md mb-4 mt-2">Go back to orders</a>
                                @endif
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection



