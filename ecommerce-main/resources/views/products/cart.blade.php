<x-app-layout>
    <div class="max-w-6xl mx-auto mt-8 p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Carrito -->
            <div class="bg-white shadow-md rounded-lg p-6 h-[76vh]">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Carrito de Compras</h2>
                <!-- Listado de productos -->
                <div class="space-y-4 overflow-auto h-[55vh]">
                    @foreach ($products as $product)
                        <div class="flex items-center space-x-4 border-b pb-4">
                            <!-- Imagen -->
                            <img src="{{ $product['image'] }}" alt="{{ $product->name }}"
                                class="w-16 h-16 object-cover rounded">
                            <!-- Detalles del producto -->
                            <div class="flex-grow">
                                <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                                <p class="text-gray-600">${{ $product->price_with_discount }} x
                                    {{ $product->quantity }}</p>
                                <p class="text-gray-800 font-bold">Subtotal:
                                    ${{ $product->subtotal }} </p>
                            </div>
                            <!-- Botones para cambiar la cantidad -->
                            <div class="flex items-center space-x-2">
                                <form action="{{ route('cart.remove', $product->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="action" value="decrease"
                                        class="bg-gray-200 px-2 py-1 rounded hover:bg-gray-300">-</button>
                                </form>
                                <span class="font-bold">{{ $product->quantity }}</span>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" name="action" value="increase"
                                        class="bg-gray-200 px-2 py-1 rounded hover:bg-gray-300">+</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Subtotal y total -->
                <div class="mt-6 border-t pt-4">
                    {{-- <p class="text-lg">Subtotal: <span class="font-bold">${{ number_format($subtotal, 2) }}</span></p> --}}
                    <p class="text-lg">Total: <span class="font-bold">${{ session('subtotal') }}</span></p>
                </div>
            </div>

            <!-- Formulario de Pedido -->
            <div class="bg-white shadow-md rounded-lg p-6 overflow-auto h-[76vh]">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Formulario de Pedido</h2>
                <form action="{{ route('order.store') }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <!-- Nombre Completo -->
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700">Nombre
                                Completo *</label>
                            <input type="text" id="full_name" name="full_name"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>
                        <!-- Dirección de Envío -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Dirección de
                                Envío *</label>
                            <input type="text" id="address" name="address"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>
                        <!-- Ciudad de Envío -->
                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">Ciudad *</label>
                            <input type="text" id="city" name="city"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>
                        <!-- Teléfono -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Teléfono *</label>
                            <input type="text" id="phone" name="phone"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                required>
                        </div>
                        <!-- Nota adicional -->
                        <div>
                            <label for="note" class="block text-sm font-medium text-gray-700">Nota Adicional</label>
                            <textarea id="note" name="note" rows="4"
                                class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                    </div>
                    <!-- Botón de Enviar -->
                    <div class="mt-6">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            Confirmar Pedido
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
