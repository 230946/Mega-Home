<x-app-layout>
    <!-- Listado de productos -->
    <main class="container mx-auto px-6 py-8">
        {{-- boton atras  --}}
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <!-- Producto (Card) -->
                <a href="{{ route('products.show', $product->id) }}"
                    class="bg-white rounded-lg shadow-md overflow-hidden relative h-[360px]">
                    <!-- Etiqueta de descuento -->
                    <div class="absolute top-2 right-2 bg-purple-500 text-white text-xs font-bold px-2 py-1 rounded">
                        {{ $product->discount }}% Off
                    </div>
                    <!-- Imagen del producto -->
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                    <!-- Contenido -->
                    <div class="p-4">
                        <!-- Título del producto -->
                        <h2 class="text-lg font-bold text-gray-800 line-clamp-3">{{ $product->name }}</h2>
                        <!-- Descripción breve -->
                        <p class="text-sm text-gray-600 mt-1 line-clamp-3 min-h-[60px]">{{ $product->description }}
                        </p>
                        <!-- Precios -->
                        <div class="flex items-center justify-between mt-4">
                            <div>
                                <span
                                    class="text-lg font-bold text-gray-800">${{ $product->price_with_discount }}</span>
                                <span
                                    class="text-sm text-gray-500 line-through ml-2">${{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                            <x-add-to-cart productId="{{ $product->id }}" />
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </main>
</x-app-layout>
