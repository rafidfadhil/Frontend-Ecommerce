@extends('admin.layouts.main')

@section('content')
<div class="w-full px-8 py-6 mx-auto">
    
    <div class="flex flex-wrap -mx-3">
        <div class="flex-none w-full max-w-full px-3">
          <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
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
                        <a href="/admin/users/create" class="inline-block min-w-min px-5 py-2.5 mt-3 mb-2 font-bold text-center text-white align-middle transition-all bg-transparent border-0 rounded-lg cursor-pointer active:opacity-85 hover:-translate-y-px hover:shadow-xs leading-normal text-sm ease-in tracking-tight-rem shadow-md bg-150 bg-x-25 bg-gradient-to-tl from-zinc-800 to-zinc-700 hover:border-slate-700 hover:bg-slate-700 hover:text-white">+ Create New User</a>
            </div>
            <div class="flex p-6 justify-start">
              <form action="" method="GET" class="flex space-x-4 w-full">
                <div class="flex-1 mr-4">
                  <label for="name" class="block mb-2">Name</label>
                  <input type="text" placeholder="Name" name="name" class="focus:shadow-primary-outline w-full text-sm leading-5.6 ease block appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none"></input>
                </div>
                <div class="flex-1 mr-4">
                  <label for="name" class="block mb-2">Role</label>
                  <select name="user_type_id" class="block w-full bg-white border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring placeholder:text-gray-500 focus:border-fuchsia-300">
                    <option value="">Select role</option>
                    <option value="1">Admin</option>
                    <option value="2">Supplier</option>
                    <option value="3">Reseller</option>
                </select>
                </div>
                <div class="flex-1 mr-4">
                  <label for="suspended" class="block mb-2">Suspended</label>
                  <select name="suspended" class="block w-full bg-white border border-gray-300 rounded-lg py-2 px-3 focus:outline-none focus:ring placeholder:text-gray-500 focus:border-fuchsia-300">
                        <option value="">Select status</option>
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                </select>
                </div>
                <div class="flex items-end">
                  <button type="submit" class="inline-block px-6 py-3 mr-3 font-bold text-center text-white uppercase align-middle transition-all rounded-lg cursor-pointer bg-cyan-500 leading-normal text-xs ease-in tracking-tight-rem shadow-xs bg-150 bg-x-25 hover:-translate-y-px active:opacity-85 hover:shadow-md">Filter</button>
                </div>
              </form>
            </div>
            <div class="flex-auto px-0 pt-0 pb-2">
              <div class="p-0 overflow-x-auto">
                <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                  <thead class="align-bottom">
                    <tr>
                      <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">No.</th>
                      <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Name</th>
                      <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Role</th>
                      <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">No. Rekening</th>
                      <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Last Logged In</th>
                      <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Suspended</th>
                      <th class="px-6 py-3 pl-2 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $user)
                    <tr>
                      <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                          <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">{{ $loop->iteration }}</p>
                      </td>
                        <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                          <div class="flex px-2 py-1">
                            <div>
                              <img src="{{ asset('images') }}/{{ $user->avatar}}" class="inline-flex items-center justify-center mr-4 text-sm text-white transition-all duration-200 ease-in-out h-9 w-9 rounded-xl" alt="user1" />
                            </div>
                            <div class="flex flex-col justify-center">
                              <h6 class="mb-0 text-sm leading-normal dark:text-white">{{ $user->name }}</h6>
                              <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">{{ $user->email }}</p>
                            </div>
                          </div>
                        </td>
                        <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                          <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">{{ $user->userType->name }}</p>
                        </td>
                        <td class="p-2 align-middle text-center bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                          <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">{{ $user->rekening }}</p>
                        </td>
                        <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                          @if ($user->last_login_at != null)
                            <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">{{ $user->last_login_at->diffForHumans() }}</p>
                          @else
                            <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-80">Never</p>
                          @endif
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                          <span class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-slate-400">
                            @if ($user->suspended == true)
                                Yes
                            @else
                                No
                            @endif
                        </span>
                        </td>
                        <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                          @if ($user->id != 1 && $user->id != auth()->user()->id)
                          <form action="/admin/users/{{ $user->id }}" method="post" class="d-inline">
                            @method('delete')
                            @csrf
                            <button class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-red-500" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>  
                          @endif
                          @if ($user->suspended == true && $user->user_type_id == 2)
                          <form action="/admin/users/{{ $user->id }}/unsuspend" method="post" class="d-inline">
                            @csrf
                            <button class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-blue-500" onclick="return confirm('Are you sure to unsuspend {{ $user->name }}?')">Unsuspend</button>
                          </form>
                          @elseif($user->suspended == false && $user->user_type_id == 2)
                            <form action="/admin/users/{{ $user->id }}/suspend" method="post" class="d-inline">
                              @csrf
                              <button class="text-xs font-semibold leading-tight dark:text-white dark:opacity-80 text-black" onclick="return confirm('Are you sure to suspend {{ $user->name }}?')">Suspend</button>
                            </form>
                          @endif
                        </td>
                      </tr>
                    @endforeach


                  </tbody>
                </table>

                <div>
                  {{ $users->links('admin.pagination.default') }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
  
</div>

@endsection