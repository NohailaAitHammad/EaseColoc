@extends('layouts.app')

@section('content')
    <main class="m-8">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4 dark:text-gray-200 uppercase">
            Categories
        </h2>
        <div class="flex items-center gap-2 mb-4">
            <div class=" border-t border-slate-100 text-left">
                <a href="{{ route('colocations.show', $colocation) }}"
                   class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-1 border border-slate-300 text-slate-700 font-semibold rounded-lg hover:bg-slate-50 hover:text-slate-900 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Retour
                </a>
            </div>
            <a href="{{ route('colocations.categories.create', $colocation) }}"
               class="px-4 py-2 text-sm font-medium text-white bg-purple-600 rounded-lg hover:bg-purple-700">
                + Nouvelle category
            </a>


        </div>
        @if ($errors->any())
            <div class="bg-red-200 p-2">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div
            class="grid gap-6  md:grid-cols-4 xl:grid-cols-5">
            @forelse($categories as $category)

                <!-- Card -->
                <div
                    class="flex items-center p-10 bg-white rounded-lg shadow-xs dark:bg-gray-800"
                >
                    <div
                        class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z"/>
                        </svg>


                    </div>
                    <div>
                        <p
                            class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
                        >
                            {{ $category->nom }}
                        </p>
                        @can('update',$category)
                        <div class="flex items-center space-x-4 text-sm">
                            <a href="{{route('colocations.categories.edit',[$colocation, $category])}}"
                               class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                               aria-label="Edit"
                            >
                                <svg
                                    class="w-5 h-5"
                                    aria-hidden="true"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                    ></path>
                                </svg>
                            </a>
                            <form action="{{ route('colocations.categories.destroy',[$colocation, $category]) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                    aria-label="Delete" type="submit"
                                >
                                    <svg
                                        class="w-5 h-5"
                                        aria-hidden="true"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        @endcan
                    </div>

                </div>
            @empty
                <h1>aucune category</h1>
            @endforelse
        </div>
    </main>
@endsection
