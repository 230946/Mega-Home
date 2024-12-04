@props(['productId' => null])
<div class="flex">
    <form action="{{ route('cart.add', $productId) }}" method="POST">
        @csrf
        @method('PATCH')
        <input type="hidden" name="product_id" value="{{ $productId }}">
       <x-button>
            Agregar al carrito
        </x-button>
    </form>
</div>
