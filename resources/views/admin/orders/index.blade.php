@extends('admin.layouts.main')

@section('content')
    <div class="w-full px-8 py-6 mx-auto">

        <div class="flex flex-wrap -mx-3">
            <div class="flex-none w-full max-w-full px-3">
                <div
                    class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                    <div class="p-6 pb-0 mb-0 border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        @if (session()->has('success'))
                        <div class="bg-emerald-500/30 border text-slate-700 px-4 py-3 rounded relative" role="alert" id="alertBox">
                            <span class="block sm:inline">{{ session('success') }}</span>
                            <button type="button" alert-close class="box-content absolute top-0 right-4  w-4 h-4 p-4 text-sm bg-transparent border-0 rounded text-slate-700 z-2 alert-close">
                              <span aria-hidden="true" class="text-center cursor-pointer">&#10005;</span>
                            </button>
                          </div>
                        @endif
                        <p class="font-bold">{{ $title }}</p>
                    </div>
                    <div class="flex p-4 justify-start">
                        <form action="" method="GET" class="flex space-x-4 w-1/2">
                            <div class="flex-auto">
                                <label for="name" class="block mb-2">Search Order by Code</label>
                                <div class="flex">
                                    <div class="relative flex flex-wrap items-stretch w-full transition-all rounded-lg ease">
                                        <span class="text-sm ease leading-5.6 absolute z-50 -ml-px flex h-full items-center whitespace-nowrap rounded-lg rounded-tr-none rounded-br-none border border-r-0 border-transparent bg-transparent py-2 px-2.5 text-center font-normal text-slate-500 transition-all">
                                          <i class="fas fa-search" aria-hidden="true"></i>
                                        </span>
                                        <input type="text" name="order_number" class="pl-9 text-sm focus:shadow-primary-outline ease w-1/100 leading-5.6 relative -ml-px block min-w-0 flex-auto rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 pr-3 text-gray-700 transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none focus:transition-shadow" placeholder="Type order code" />
                                      </div>
                                    <button type="submit"
                                        class="inline-block ml-2 px-6 py-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-black leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md">Search</button>
                                </div>
                            </div>
                        </form>
                      </div>
                    <div class="flex p-6 justify-start">
                        <form action="" method="GET" class="flex space-x-4 w-full">
                          <div class="flex-1 mr-4">
                            <label for="order_payment" class="block mb-2">Reseller Payment Status</label>
                            <select name="order_payment" class="block w-full bg-white border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring placeholder:text-gray-500 focus:border-fuchsia-300">
                                <option value="">Select status</option>
                                <option value="Ditolak">Ditolak</option>
                                <option value="Pending">Pending</option>
                                <option value="Sukses">Sukses</option>
                            </select>
                          </div>
                          <div class="flex-1 mr-4">
                            <label for="supplier_payment_status" class="block mb-2">Supplier Payment Status</label>
                            <select name="supplier_payment_status" class="block w-full bg-white border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring placeholder:text-gray-500 focus:border-fuchsia-300">
                                  <option value="">Select status</option>
                                  <option value="pending">Pending</option>
                                  <option value="Paid">Paid</option>
                          </select>
                          </div>
                          <div class="flex-1 mr-4">
                            <label for="order_status" class="block mb-2">Order Status</label>
                            <select name="order_status" class="block w-full bg-white border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring placeholder:text-gray-500 focus:border-fuchsia-300">
                                  <option value="">Select status</option>
                                  <option value="Menunggu Konfirmasi">Menunggu Konfirmasi</option>
                                  <option value="Diproses">Diproses</option>
                                  <option value="Proses Pengiriman">Proses Pengiriman</option>
                                  <option value="Ditolak">Ditolak</option>
                                  <option value="Selesai">Selesai</option>
                          </select>
                          </div>
                          <div class="flex items-end">
                            <button type="submit" class="inline-block px-6 py-3 mr-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-cyan-500 leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md">Filter</button>
                          </div>
                        </form>
                      </div>
                    <div class="flex-auto px-0 pt-0 pb-2">
                        <div class="p-0 overflow-x-auto">
                            <table
                                class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                                <thead class="align-bottom">
                                    <tr>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            No.</th>
                                        <th
                                            class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Order Code</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Reseller Payment Status</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Order Status</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Supplier Payment Status</th>
                                        <th
                                            class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mergedOrders as $order)
                                        <tr>
                                            <td
                                                    class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                    <p
                                                        class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">
                                                        {{ $loop->iteration }}</p>
                                                </td>
                                                <td
                                                    class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                    <p
                                                        class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">
                                                        {{ $order['order_number'] }}</p>
                                                </td>
                                            <td
                                                class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                <p
                                                    class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">
                                                    {{ $order['order_payment'] }}</p>
                                            </td>
                                            <td
                                                class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                <p
                                                    class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">
                                                    {{ $order['order_status'] }}</p>
                                            </td>
                                            <td
                                                class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                <p
                                                    class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">
                                                    {{ $order['supplier_payment_status'] }}</p>
                                            </td>
                                            <td
                                                class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                                <a href="/admin/orders/{{ $order['order_number'] }}/show?supplier_id={{ $order['supplier_id'] }}"
                                                    class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400 mr-2">
                                                    View</a>
                                                @if ($order['order_status'] == 'Selesai' && $order['supplier_payment_status'] == 'pending')
                                                <a href="/admin/orders/{{ $order['order_number'] }}/payment?supplier_id={{ $order['supplier_id'] }}"
                                                class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-blue-500" >
                                                Pay Supplier </a>  
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div>
                                {{ $mergedOrders->links('admin.pagination.default') }}
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>
@endsection
