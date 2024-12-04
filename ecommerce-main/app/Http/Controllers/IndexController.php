<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderByDesc('discount')->when(strlen(request('search')) > 0, function ($q) {
            $q->where('name', 'like', '%' . request('search') . '%');
        })->get();
        $categories = Category::orderBy('name')->get();
        session()->put('categories', $categories);

        return view('dashboard', compact('products'));
    }

    public function storeOrder(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'note' => 'nullable|string',
        ]);

        $this->setCartSubtotal();

        // Verificar que el carrito no esté vacío
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'El carrito está vacío.');
        }

        // Calcular el total y descuento general del carrito
        $subtotal = str_replace([',', '.'], '', session()->get('subtotal'));
        $discount = 0;
        foreach ($cart as $item) {
            $price = str_replace([',', '.'], '', $item['price']);
            $price_with_discount = str_replace([',', '.'], '', $item['price_with_discount']);
            $discount += ($price - $price_with_discount) * $item['quantity'];
        }

        $total = $subtotal; // el subtotal general ya tiene descuento

        // Crear la dirección asociada a la orden
        $address = Address::create([
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'city' => $validated['city'],
            'neighborhood' => $request->input('neighborhood', 'N/A'), // Campo opcional
            'detail' => $request->input('detail', 'N/A'), // Campo opcional
        ]);

        // Crear la orden
        $order = Order::create([
            'user_id' => auth()->id(), // Asegúrate de que el usuario esté autenticado
            'address_id' => $address->id,
            'total' => $total,
            'discount' => $discount,
            'notes' => $validated['note'],
        ]);

        // Asociar productos del carrito a la orden
        foreach ($cart as $productId => $productDetails) {
            $order->products()->attach($productId, [
                'quantity' => $productDetails['quantity'],
                'subtotal' => $productDetails['subtotal'],
            ]);
        }

        // Limpiar el carrito de la sesión
        session()->forget(['cart', 'subtotal']);

        // Redirigir con éxito
        return redirect()->route('dashboard', $order->id)->with('success', 'Orden creada exitosamente.');
    }

    /**
     * Display the cart with the products.
     *
     * @return \Illuminate\View\View
     */
    public function cart()
    {
        $cart = session()->get('cart', []);
        $products = Product::whereIn('id', array_keys($cart))->get();

        foreach ($products as $product) {
            $product->quantity = $cart[$product->id]['quantity'] ?? 0;
            $product->subtotal = $cart[$product->id]['subtotal'] ?? 0;
        }

        return view('products.cart', compact('products'));
    }

    public function addCart($productId)
    {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart');

        if (!$cart) {
            $cart = [
                $productId => [
                    'name' => $product->name,
                    'quantity' => 1,
                    'price' => $product->price,
                    'discount' => $product->discount,
                    'image' => $product->image,
                    'price_with_discount' => $product->price_with_discount
                ]
            ];
            session()->put('cart', $cart);
            $this->setCartSubtotal();
            return redirect()->back()->with('success', 'Se ha añadido el producto al carrito');
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
            session()->put('cart', $cart);
            $this->setCartSubtotal();
            return redirect()->back()->with('success', 'Se ha añadido el producto al carrito');
        }

        $cart[$productId] = [
            'name' => $product->name,
            'quantity' => 1,
            'price' => $product->price,
            'discount' => $product->discount,
            'image' => $product->image,
            'price_with_discount' => $product->price_with_discount
        ];
        session()->put('cart', $cart);
        $this->setCartSubtotal();
        return redirect()->back()->with('success', 'Se ha añadido el producto al carrito');
    }

    /**
     * Fijar el subtotal de todos los productos del carrito
     *
     * @return void
     */
    private function setCartSubtotal()
    {
        $cart = session()->get('cart');
        $subtotal = 0;
        foreach ($cart as $productId => $product) {
            $subtotal += $product['price_with_discount'] * $product['quantity'];
            session()->put('cart.' . $productId . '.subtotal', $product['price_with_discount'] * $product['quantity']);
        }
        session()->put('subtotal', $subtotal);
    }

    /**
     * Resta 1 a la cantidad de un producto en el carrito, si es 0, se elimina.
     *
     * @param [type] $productId
     * @return void
     */
    public function removeCart($productId)
    {
        $cart = session()->get('cart');
        if (isset($cart[$productId])) {
            if ($cart[$productId]['quantity'] > 1) {
                $cart[$productId]['quantity']--;
                session()->put('cart', $cart);
            } else {
                unset($cart[$productId]);
                session()->put('cart', $cart);
            }
            $this->setCartSubtotal();
            return redirect()->back()->with('success', 'Se ha eliminado un producto del carrito');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $productId)
    {
        $product = Product::findOrFail($productId);

        return view('products.show', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
