@extends('layouts.app')

@section('title', 'Menus - '.config('app.name', 'Laravel'))
@section('page_eyebrow', 'Navigation Manager')
@section('page_heading', 'Menus')

@section('page_header')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 text-gray-800">Menus</h1>
            <p class="mb-0 text-muted">Add menu links, update their targets, and drag rows to keep the frontend navigation in the right order.</p>
        </div>
        <div class="mt-3 mt-sm-0 d-flex flex-wrap">
            <span class="badge badge-primary badge-pill px-3 py-2 mr-2 mb-2">{{ $menus->count() }} Menu Items</span>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary btn-sm mb-2">Back to Dashboard</a>
        </div>
    </div>
@endsection

@section('content')
    @if (session('status'))
        <div class="alert alert-success shadow-sm" role="alert">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger shadow-sm" role="alert">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Add Menu Item</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Create a new frontend navigation item using a label and target URL or section ID.</p>

                    <form action="{{ route('menus.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="menu-label">Menu Label</label>
                            <input
                                id="menu-label"
                                name="label"
                                type="text"
                                class="form-control"
                                value="{{ old('label') }}"
                                placeholder="Menu name"
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label for="menu-link">Target Link</label>
                            <input
                                id="menu-link"
                                name="target"
                                type="text"
                                class="form-control"
                                value="{{ old('target') }}"
                                placeholder="#section-id or /page"
                                required
                            >
                        </div>

                        <input type="hidden" name="sort_order" value="{{ $menus->count() + 1 }}">

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-plus mr-1"></i>
                            Add Menu
                        </button>
                    </form>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Tips</h6>
                </div>
                <div class="card-body">
                    <ul class="mb-0 pl-3 text-muted small">
                        <li class="mb-2">Use clear menu labels so your homepage stays easy to scan.</li>
                        <li class="mb-2">Targets can link to a full page like <strong>/contact</strong> or a section like <strong>#placements</strong>.</li>
                        <li>Drag the handle in the list to reorder items. The new order saves automatically.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                    <div>
                        <h6 class="m-0 font-weight-bold text-primary">Menu List</h6>
                        <div class="small text-muted mt-1">Drag rows to reorder items, then edit labels and links inline and save changes per row.</div>
                    </div>
                    <span class="badge badge-light border text-uppercase mt-3 mt-md-0">{{ $menus->count() }} Total</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="menu-table">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">Move</th>
                                    <th class="border-0">Order</th>
                                    <th class="border-0">Menu</th>
                                    <th class="border-0">Link</th>
                                    <th class="border-0">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="menu-table-body">
                                @forelse ($menus as $menu)
                                    @php($formId = 'menu-update-'.$menu->id)
                                    <tr class="menu-row" data-menu-id="{{ $menu->id }}" draggable="true">
                                        <td class="align-middle">
                                            <span class="menu-drag-handle" title="Drag to reorder">
                                                <i class="fas fa-grip-vertical"></i>
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            <span class="badge badge-primary badge-pill order-badge">{{ $loop->iteration }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <input
                                                form="{{ $formId }}"
                                                name="label"
                                                type="text"
                                                class="form-control form-control-sm"
                                                value="{{ $menu->label }}"
                                                required
                                            >
                                        </td>
                                        <td class="align-middle">
                                            <input
                                                form="{{ $formId }}"
                                                name="target"
                                                type="text"
                                                class="form-control form-control-sm"
                                                value="{{ $menu->target }}"
                                                required
                                            >
                                        </td>
                                        <td class="align-middle">
                                            <div class="d-flex flex-wrap">
                                                <form action="{{ route('menus.update', $menu) }}" id="{{ $formId }}" method="POST" class="mr-2 mb-2 mb-sm-0">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input form="{{ $formId }}" name="sort_order" type="hidden" value="{{ $menu->sort_order }}">
                                                    <button type="submit" class="btn btn-primary btn-sm">Save</button>
                                                </form>
                                                <form action="{{ route('menus.destroy', $menu) }}" method="POST" onsubmit="return confirm('Delete this menu item?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-5">No menu items found yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form action="{{ route('menus.reorder') }}" id="menu-order-form" method="POST" class="d-none">
        @csrf
        @method('PATCH')
        <div id="menu-order-inputs"></div>
    </form>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tableBody = document.getElementById('menu-table-body');
            const orderForm = document.getElementById('menu-order-form');
            const orderInputs = document.getElementById('menu-order-inputs');

            if (!tableBody || !orderForm || !orderInputs) {
                return;
            }

            let draggedRow = null;
            let hasOrderChanged = false;

            const updateOrderUI = () => {
                Array.from(tableBody.querySelectorAll('.menu-row')).forEach((row, index) => {
                    const badge = row.querySelector('.order-badge');

                    if (badge) {
                        badge.textContent = String(index + 1);
                    }
                });
            };

            const buildOrderInputs = () => {
                orderInputs.innerHTML = '';

                Array.from(tableBody.querySelectorAll('.menu-row')).forEach((row) => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'menu_ids[]';
                    input.value = row.dataset.menuId;
                    orderInputs.appendChild(input);
                });
            };

            const getRowAfterCursor = (container, y) => {
                const rows = [...container.querySelectorAll('.menu-row:not(.menu-row-dragging)')];

                return rows.reduce((closest, row) => {
                    const box = row.getBoundingClientRect();
                    const offset = y - box.top - (box.height / 2);

                    if (offset < 0 && offset > closest.offset) {
                        return { offset, element: row };
                    }

                    return closest;
                }, { offset: Number.NEGATIVE_INFINITY, element: null }).element;
            };

            tableBody.querySelectorAll('.menu-row').forEach((row) => {
                row.addEventListener('dragstart', () => {
                    draggedRow = row;
                    hasOrderChanged = false;
                    row.classList.add('menu-row-dragging');
                });

                row.addEventListener('dragend', () => {
                    row.classList.remove('menu-row-dragging');

                    if (hasOrderChanged) {
                        buildOrderInputs();
                        orderForm.submit();
                    }

                    draggedRow = null;
                });
            });

            tableBody.addEventListener('dragover', (event) => {
                event.preventDefault();

                if (!draggedRow) {
                    return;
                }

                const afterElement = getRowAfterCursor(tableBody, event.clientY);

                if (!afterElement) {
                    if (tableBody.lastElementChild !== draggedRow) {
                        tableBody.appendChild(draggedRow);
                        hasOrderChanged = true;
                        updateOrderUI();
                    }

                    return;
                }

                if (afterElement !== draggedRow && afterElement.previousElementSibling !== draggedRow) {
                    tableBody.insertBefore(draggedRow, afterElement);
                    hasOrderChanged = true;
                    updateOrderUI();
                }
            });
        });
    </script>
@endpush
