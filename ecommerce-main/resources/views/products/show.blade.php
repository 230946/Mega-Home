<x-app-layout>
    <div class="max-w-6xl mx-auto mt-8 p-4 relative">
        <a href="{{ route('dashboard') }}"
            class="absolute top-[-25px] px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Ir Atrás</a>
        <!-- Producto -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Imagen del producto -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="relative">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg">
                    <!-- Etiqueta de descuento -->
                    <div class="absolute top-2 right-2 bg-purple-500 text-white text-xl font-bold px-2 py-1 rounded">
                        {{ $product->discount }}% OFF
                    </div>
                </div>

                <!-- Información del producto -->
                <div>
                    <!-- Nombre -->
                    <h1 class="text-2xl font-bold text-gray-800">{{ $product->name }}</h1>

                    <!-- Precio -->
                    <div class="mt-4">
                        @if ($product->discount > 0)
                            <div class="flex items-center space-x-2">
                                <span class="text-2xl font-bold text-green-600">
                                    ${{ $product->price_with_discount }}
                                </span>
                                <span class="line-through text-gray-500 text-lg">
                                    ${{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <span class="text-sm text-red-500 font-semibold">
                                    {{ $product->discount }}% OFF
                                </span>
                            </div>
                        @else
                            <span class="text-2xl font-bold text-gray-800">
                                ${{ number_format($product->price, 0, ',', '.') }}
                            </span>
                        @endif
                    </div>

                    <!-- Descripción -->
                    <p class="mt-4 text-gray-600">
                        {{ $product->description }}
                    </p>

                    <!-- Botones -->
                    <div class="mt-6">
                        <x-add-to-cart productId="{{ $product->id }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
