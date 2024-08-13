@extends('admin.layouts.main')

@section('content')
          <!-- cards -->
          <div class="w-full px-6 py-6 mx-auto">
            <!-- row 1 -->
            <div class="flex flex-wrap -mx-3">
              <!-- card1 -->
              <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                  <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                      <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                          <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Income</p>
                          <h5 class="mb-2 font-bold dark:text-white">{{ number_format($income) }}</h5>
{{--                           <p class="mb-0 dark:text-white dark:opacity-60">
                            <span class="text-sm font-bold leading-normal text-emerald-500">+55%</span>
                            since yesterday
                          </p> --}}
                        </div>
                      </div>
                      <div class="px-3 text-right basis-1/3">
                        <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-blue-500 to-violet-500">
                          <i class="ni leading-none ni-money-coins text-lg relative top-3.5 text-white"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
    
              <!-- card2 -->
              <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                  <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                      <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                          <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Users </p>
                          <h5 class="mb-2 font-bold dark:text-white">{{ $userCount }}</h5>
{{--                           <p class="mb-0 dark:text-white dark:opacity-60">
                            <span class="text-sm font-bold leading-normal text-emerald-500">+3%</span>
                            since last week
                          </p> --}}
                        </div>
                      </div>
                      <div class="px-3 text-right basis-1/3">
                        <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600">
                          <i class="ni leading-none ni-world text-lg relative top-3.5 text-white"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
    
              <!-- card3 -->
              <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                  <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                      <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                          <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Products</p>
                          <h5 class="mb-2 font-bold dark:text-white">{{ $productCount }}</h5>
{{--                           <p class="mb-0 dark:text-white dark:opacity-60">
                            <span class="text-sm font-bold leading-normal text-red-600">-2%</span>
                            since last quarter
                          </p> --}}
                        </div>
                      </div>
                      <div class="px-3 text-right basis-1/3">
                        <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-emerald-500 to-teal-400">
                          <i class="ni leading-none ni-paper-diploma text-lg relative top-3.5 text-white"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
    
              <!-- card4 -->
              <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
                  <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                      <div class="flex-none w-2/3 max-w-full px-3">
                        <div>
                          <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Pending Payments</p>
                          <h5 class="mb-2 font-bold dark:text-white">{{ $pendingPaymentCount }}</h5>
{{--                           <p class="mb-0 dark:text-white dark:opacity-60">
                            <span class="text-sm font-bold leading-normal text-emerald-500">+5%</span>
                            than last month
                          </p> --}}
                        </div>
                      </div>
                      <div class="px-3 text-right basis-1/3">
                        <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-orange-500 to-yellow-500">
                          <i class="ni leading-none ni-cart text-lg relative top-3.5 text-white"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
    
            <!-- cards row 2 -->
    
            <!-- cards row 3 -->
    
            <div class="flex flex-wrap mt-6 -mx-3">
              <!--Charts-->
              <div class="w-full max-w-full px-3 mt-0 lg:w-7/12 lg:flex-none">
                <div class="border-black/12.5 dark:bg-slate-850 dark:shadow-dark-xl shadow-xl relative z-20 flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                  <div class="border-black/12.5 mb-0 rounded-t-2xl border-b-0 border-solid p-6 pt-4 pb-0">
                    <h6 class="capitalize dark:text-white">Sales overview</h6>
{{--                     <p class="mb-0 text-sm leading-normal dark:text-white dark:opacity-60">
                      <i class="fa fa-arrow-up text-emerald-500"></i>
                      <span class="font-semibold">4% more</span> in 2021
                    </p> --}}
                  </div>
                  <div class="flex-auto p-4">
                    <div>
                      <canvas id="chart-line" height="300"></canvas>
                    </div>
                  </div>
                </div>
              </div>
              <!--Ranking Kategori-->
              <div class="w-full max-w-full px-3 mt-0 lg:w-5/12 lg:flex-none">
                <div class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                  <div class="p-4 pb-0 rounded-t-4">
                    <h6 class="mb-0 dark:text-white">Categories</h6>
                  </div>
                  <div class="flex-auto p-4">
                    <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                      <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-t-lg rounded-xl text-inherit">
                        <div class="flex items-center">
                          <div class="inline-block w-8 h-8 mr-4 text-center text-black bg-center shadow-sm fill-current stroke-none bg-gradient-to-tl from-zinc-800 to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850 rounded-xl">
                            <i class="text-white ni ni-mobile-button relative top-0.75 text-xxs"></i>
                          </div>
                          <div class="flex flex-col">
                            <h6 class="mb-1 text-sm leading-normal text-slate-700 dark:text-white">Suspended users</h6>
                            <span class="text-xs leading-tight dark:text-white/80">{{ $suspendedUserCount }} <span class="font-semibold">users</span></span>
                          </div>
                        </div>
                        <div class="flex">
                          <a href="/admin/users" class="group ease-in leading-pro text-xs rounded-3.5xl p-1.2 h-6.5 w-6.5 mx-0 my-auto inline-block cursor-pointer border-0 bg-transparent text-center align-middle font-bold text-slate-700 shadow-none transition-all dark:text-white">
                            <i class="ni ease-bounce text-2xs group-hover:translate-x-1.25 ni-bold-right transition-all duration-200" aria-hidden="true"></i>
                          </a> 
                        </div>
                      </li>
                      <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-xl text-inherit">
                        <div class="flex items-center">
                          <div class="inline-block w-8 h-8 mr-4 text-center text-black bg-center shadow-sm fill-current stroke-none bg-gradient-to-tl from-zinc-800 to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850 rounded-xl">
                            <i class="text-white ni ni-tag relative top-0.75 text-xxs"></i>
                          </div>
                          <div class="flex flex-col">
                            <h6 class="mb-1 text-sm leading-normal text-slate-700 dark:text-white">Rejected orders</h6>
                            <span class="text-xs leading-tight dark:text-white/80">{{ $rejectedOrders }}<span class="font-semibold"> orders</span></span>
                          </div>
                        </div>
                        <div class="flex">
                          <a href="/admin/orders" class="group ease-in leading-pro text-xs rounded-3.5xl p-1.2 h-6.5 w-6.5 mx-0 my-auto inline-block cursor-pointer border-0 bg-transparent text-center align-middle font-bold text-slate-700 shadow-none transition-all dark:text-white">
                            <i class="ni ease-bounce text-2xs group-hover:translate-x-1.25 ni-bold-right transition-all duration-200" aria-hidden="true"></i>
                          </a> 
                        </div>
                      </li>
                      <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-b-lg rounded-xl text-inherit">
                        <div class="flex items-center">
                          <div class="inline-block w-8 h-8 mr-4 text-center text-black bg-center shadow-sm fill-current stroke-none bg-gradient-to-tl from-zinc-800 to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850 rounded-xl">
                            <i class="text-white ni ni-box-2 relative top-0.75 text-xxs"></i>
                          </div>
                          <div class="flex flex-col">
                            <h6 class="mb-1 text-sm leading-normal text-slate-700 dark:text-white">Most sold product</h6>
                            <span class="text-xs leading-tight dark:text-white/80">{{ $mostSoldProduct->product_name }},<span class="font-semibold"> {{ $mostSoldProduct->total_quantity_ordered }} sold</span></span>
                          </div>
                        </div>
                        <div class="flex">
                          <a href="/admin/products" class="group ease-in leading-pro text-xs rounded-3.5xl p-1.2 h-6.5 w-6.5 mx-0 my-auto inline-block cursor-pointer border-0 bg-transparent text-center align-middle font-bold text-slate-700 shadow-none transition-all dark:text-white">
                            <i class="ni ease-bounce text-2xs group-hover:translate-x-1.25 ni-bold-right transition-all duration-200" aria-hidden="true"></i>
                          </a> 
                        </div>
                      </li>
                      <li class="relative flex justify-between py-2 pr-4 border-0 rounded-b-lg rounded-xl text-inherit">
                        <div class="flex items-center">
                          <div class="inline-block w-8 h-8 mr-4 text-center text-black bg-center shadow-sm fill-current stroke-none bg-gradient-to-tl from-zinc-800 to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850 rounded-xl">
                            <i class="text-white ni ni-satisfied relative top-0.75 text-xxs"></i>
                          </div>
                          <div class="flex flex-col">
                            <h6 class="mb-1 text-sm leading-normal text-slate-700 dark:text-white">Pending supplier payment</h6>
                            <span class="text-xs leading-tight dark:text-white/80"><span class="font-semibold">{{ $pendingSupplierPayment }} </span></span>
                          </div>
                        </div>
                        <div class="flex">
                          <a href="/admin/orders" class="group ease-in leading-pro text-xs rounded-3.5xl p-1.2 h-6.5 w-6.5 mx-0 my-auto inline-block cursor-pointer border-0 bg-transparent text-center align-middle font-bold text-slate-700 shadow-none transition-all dark:text-white">
                            <i class="ni ease-bounce text-2xs group-hover:translate-x-1.25 ni-bold-right transition-all duration-200" aria-hidden="true"></i>
                          </a>                          
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
    
            <footer class="pt-4">
              <div class="w-full px-6 mx-auto">
                <div class="flex flex-wrap items-center -mx-3 lg:justify-between">
                  <div class="w-full max-w-full px-3 mt-0 mb-6 shrink-0 lg:mb-0 lg:w-1/2 lg:flex-none">
                    <div class="text-sm leading-normal text-center text-slate-500 lg:text-left">
                      ©
                      <script>
                        document.write(new Date().getFullYear() + ",");
                      </script>
                      made by
                      <a href="#" class="font-semibold text-slate-700 dark:text-white" target="_blank">MITRA.ID</a>
    
                    </div>
                  </div>
                </div>
              </div>
            </footer>
          </div>
          <!-- end cards -->
@endsection