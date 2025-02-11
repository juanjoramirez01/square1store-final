<x-guest-layout>
    <main class="wrapper flex-1 py-20 box-border">
        <h1 class="text-center text-black text-3xl font-black mb-20">
            {{__('Mis ordenes')}}
        </h1>

        <div>

            <div class="px-4 sm:px-6 lg:px-8">
                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div class="overflow-hidden ring-1 shadow-sm ring-black/5 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                            {{__('Orden')}}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            {{__('Nombre')}}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            {{__('Dirección')}}</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                            {{__('Precio')}}</th>
                                        <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-6">
                                            <span class="sr-only">{{__('Acciones')}}</span>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                        @foreach($orders as $order)
                                            <tr>
                                                <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-6">
                                                    {{__('Orden # :number', ['number' => $order->id])}}
                                                </td>
                                                <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">{{$order->name}}</td>
                                                <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">{{$order->address}}</td>
                                                <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">
                                                    {{$order->price}}
                                                </td>
                                                <td class="relative py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6">
                                                    <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                                        {{__('Ver orden')}}
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-10">
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
</x-guest-layout>
