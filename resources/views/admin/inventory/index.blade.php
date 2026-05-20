@extends('layouts.admin')

@section('title', 'Inventory')

@section('content')

<div class="container-fluid">

    <div class="row">

        <div class="col-12">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <div>

                    <h1 class="fs-3 mb-1">
                        Inventory
                    </h1>

                    <p class="mb-0">
                        Manage your product inventory
                    </p>

                </div>

                <div>

                    <a href="{{ route('products.create') }}"
                        class="btn btn-primary">

                        Add Product

                    </a>

                </div>

            </div>

        </div>

    </div>

    <div class="row">

        <div class="col-12">

            <div class="d-flex gap-2 mb-3 flex-wrap justify-content-between">

                <input type="text"
                    class="form-control"
                    placeholder="Search products..."
                    style="max-width: 250px;">

                <div class="d-flex gap-2">

                    <button class="btn btn-outline-secondary">
                        <i class="ti ti-filter"></i> Filter
                    </button>

                    <button class="btn btn-outline-secondary">
                        <i class="ti ti-file-excel"></i> Excel
                    </button>

                    <button class="btn btn-outline-secondary">
                        <i class="ti ti-file-pdf"></i> PDF
                    </button>

                </div>

            </div>

            <div class="card table-responsive">

                <table class="table mb-0 text-nowrap table-hover">

                    <thead class="table-light border-light">

                        <tr>

                            <th>Image</th>
                            <th>Code</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Price</th>
                            <th>Unit</th>
                            <th>Quantity</th>
                            <th>Action</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse ($products as $product)

                        <tr class="align-middle">

                            <td>

                                <img src="{{ asset('storage/' . $product->photo) }}"
                                    class="avatar avatar-md rounded">

                                <span class="ms-3">
                                    {{ $product->name }}
                                </span>

                            </td>

                            <td>{{ $product->code }}</td>

                            <td>{{ $product->category }}</td>

                            <td>{{ $product->brand }}</td>

                            <td>
                                Rp {{ number_format($product->harga_jual) }}
                            </td>

                            <td>{{ $product->unit }}</td>

                            <td>{{ $product->stock }}</td>

                            <td>

                                <a href="{{ route('products.edit', $product->id) }}">

                                    <i class="ti ti-edit"></i>

                                </a>

                                <form action="{{ route('products.destroy', $product->id) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="border-0 bg-transparent link-danger">

                                        <i class="ti ti-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="8" class="text-center py-4">
                                No products found
                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection