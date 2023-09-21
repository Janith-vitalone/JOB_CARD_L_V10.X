<div id="left-sidebar" class="sidebar">
    <div class="navbar-brand">
        <a href="{{ route('home') }}"><img src="{{ asset('assets/images/logo/Senevi-white.png') }}" alt="Helium Logo" class="img-fluid" style="width: 100px;"></a>
        <button type="button" class="btn-toggle-offcanvas btn btn-sm float-right"><i class="lnr lnr-menu icon-close"></i></button>
    </div>
    <div class="sidebar-scroll">
        <div class="user-account">
            <div class="user_div">
                <img src="{{ url('/assets/avatars/' . Auth::user()->avatar) }}" class="user-photo" alt="User Profile Picture">
            </div>
            <div class="dropdown">
                <span>Welcome,</span>
                <a href="javascript:void(0);" class="dropdown-toggle user-name" data-toggle="dropdown"><strong>{{ Auth::user()->name }} {{ Auth::user()->last_name }}</strong></a>
                <ul class="dropdown-menu dropdown-menu-right account vivify flipInY">
                    <li><a href="{{ route('user.profile', ['id' => Auth::user()->id]) }}"><i class="icon-user"></i>My Profile</a></li>
                    <li class="divider"></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="icon-power"></i>Logout</a></li>
                </ul>
            </div>
        </div>
        <nav id="left-sidebar-nav" class="sidebar-nav">
            <ul id="main-menu" class="metismenu">
                <li class="header">Main</li>
                <li @if (\Request::is('dashboard')) class='active open' @endif><a href="{{ route('home') }}"><i class="icon-speedometer"></i><span>Dashboard</span></a></li>

                <li class="header">User Management</li>
                <li @if (\Request::is('user/*') || \Request::is('user')) class='active open' @endif>
                    <a href="#Contact" class="has-arrow"><i class="icon-user"></i><span>User</span></a>
                    <ul>
                        <li @if (\Request::is('user/create')) class='active' @endif><a href="{{ route('user.create') }}">Create</a></li>
                        <li @if (\Request::is('user')) class='active' @endif><a href="{{ route('user.index') }}">Manage</a></li>
                    </ul>
                </li>
                <li @if (\Request::is('designation/*') || \Request::is('designation')) class='active open' @endif>
                    <a href="#designation" class="has-arrow"><i class="icon-graduation"></i><span>Designation</span></a>
                    <ul>
                        <li @if (\Request::is('designation/create')) class='active' @endif><a href="{{ route('designation.create') }}">Create</a></li>
                        <li @if (\Request::is('designation')) class='active' @endif><a href="{{ route('designation.index') }}">Manage</a></li>
                    </ul>
                </li>
                <li @if (\Request::is('user-role/*') || \Request::is('user-role')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-badge"></i><span>User Role</span></a>
                    <ul>
                        <li @if (\Request::is('user-role/create')) class='active' @endif><a href="{{ route('user-role.create') }}">Create</a></li>
                        <li @if (\Request::is('user-role')) class='active' @endif><a href="{{ route('user-role.index') }}">Manage</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#Contact" class="has-arrow"><i class="icon-user-following"></i><span>Assign User Roles</span></a>
                    <ul>
                        <li @if (\Request::is('user-assign/create')) class='active open' @endif><a href="{{ route('user-assign.create') }}">Assign</a></li>
                        <li @if (\Request::is('user-assign')) class='active open' @endif><a href="{{ route('user-assign.index') }}">Manage</a></li>
                    </ul>
                </li>
                <li @if (\Request::is('permission/*') || \Request::is('permission')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-lock"></i><span>Permission</span></a>
                    <ul>
                        <li @if (\Request::is('permission/create')) class='active' @endif><a href="{{ route('permission.create') }}">Create</a></li>
                        <li @if (\Request::is('permission')) class='active' @endif><a href="{{ route('permission.index') }}">Manage</a></li>
                    </ul>
                </li>
                <li @if (\Request::is('assign-permission/*') || \Request::is('assign-permission')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-lock-open"></i><span>Assign Permission</span></a>
                    <ul>
                        <li @if (\Request::is('assign-permission/create')) class='active' @endif><a href="{{ route('assign-permission.create') }}">Create</a></li>
                        <li @if (\Request::is('assign-permission')) class='active' @endif><a href="{{ route('assign-permission.index') }}">Manage</a></li>
                    </ul>
                </li>

                <li class="header">Job Management</li>

                <li @if (\Request::is('jobcard/*') || \Request::is('jobcard')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-list"></i><span>Job Card</span></a>
                    <ul>
                        <li @if (\Request::is('jobcard/create')) class='active' @endif><a href="{{ route('jobcard.create') }}">Create</a></li>
                        <li @if (\Request::is('jobcard')) class='active' @endif><a href="{{ route('jobcard.index') }}">Manage</a></li>
                    </ul>
                </li>
                <li @if (\Request::is('invoice/*') || \Request::is('invoice')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-drawer"></i><span>Invoice</span></a>
                    <ul>
                        <li @if (\Request::is('invoice/create')) class='active' @endif><a href="{{ route('invoice.create') }}">Create</a></li>
                        <li @if (\Request::is('invoice')) class='active' @endif><a href="{{ route('invoice.index') }}">Manage</a></li>
                    </ul>
                </li>
                <li @if (\Request::is('quotation/*') || \Request::is('quotation')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-doc"></i><span>Quotation</span></a>
                    <ul>
                        <li @if (\Request::is('quotation/create')) class='active' @endif><a href="{{ route('quotation.create') }}">Create</a></li>
                        <li @if (\Request::is('quotation')) class='active' @endif><a href="{{ route('quotation.index') }}">Manage</a></li>
                    </ul>
                </li>

                <li class="header">Stock Management</li>

                <li @if (\Request::is('stock/*') || \Request::is('stock')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-book-open"></i><span>Stock</span></a>
                    <ul>
                        <li @if (\Request::is('stock')) class='active' @endif><a href="{{ route('stock.index') }}">Manage</a></li>
                    </ul>
                </li>

                <li @if (\Request::is('stock-approvel/*') || \Request::is('stock-approvel')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-book-open"></i><span>Stock Approvel</span></a>
                    <ul>
                        <li @if (\Request::is('stock-approvel')) class='active' @endif><a href="{{ route('stock-approvel.index') }}">Manage</a></li>
                    </ul>
                </li>

                <li @if (\Request::is('stockin/*') || \Request::is('stockin')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-book-open"></i><span>Stock In</span></a>
                    <ul>
                    <li @if (\Request::is('stockin/create')) class='active' @endif><a href="{{ route('stockin.create') }}">Create</a></li>
                        <li @if (\Request::is('stockin')) class='active' @endif><a href="{{ route('stockin.index') }}">Manage</a></li>
                    </ul>
                </li>

                <li @if (\Request::is('stock-product-category/*') || \Request::is('stock-product-category')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-book-open"></i><span>Stock Product Category</span></a>
                    <ul>
                        <li @if (\Request::is('stock-product-category/create')) class='active' @endif><a href="{{ route('stock-product-category.create') }}">Create</a></li>
                        <li @if (\Request::is('stock-product-category')) class='active' @endif><a href="{{ route('stock-product-category.index') }}">Manage</a></li>
                    </ul>
                </li>

                <li @if (\Request::is('supplier-product/*') || \Request::is('supplier-product')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-book-open"></i><span>Supplier Product</span></a>
                    <ul>
                        <li @if (\Request::is('supplier-product/create')) class='active' @endif><a href="{{ route('supplier-product.create') }}">Create</a></li>
                        <li @if (\Request::is('supplier-product')) class='active' @endif><a href="{{ route('supplier-product.index') }}">Manage</a></li>
                    </ul>
                </li>

                <li @if (\Request::is('supplier/*') || \Request::is('supplier')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-book-open"></i><span>Supplier</span></a>
                    <ul>
                        <li @if (\Request::is('supplier/create')) class='active' @endif><a href="{{ route('supplier.create') }}">Create</a></li>
                        <li @if (\Request::is('supplier')) class='active' @endif><a href="{{ route('supplier.index') }}">Manage</a></li>
                    </ul>
                </li>



                <li class="header">Reporting</li>

                <li @if (\Request::is('reports/*') || \Request::is('reports')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-book-open"></i><span>Reports</span></a>
                    <ul>
                        <li @if (\Request::is('reports/invoices')) class='active' @endif><a href="{{ route('invoice.report') }}">Invoices</a></li>
                        <li @if (\Request::is('reports/items')) class='active' @endif><a href="{{ route('item.report') }}">Items</a></li>
                        <li @if (\Request::is('reports/other-payment')) class='active' @endif><a href="{{ route('other_payment.report') }}">Other Payment</a></li>
                        <li @if (\Request::is('reports/profitandloss')) class='active' @endif><a href="{{ route('profit_and_loss.report') }}">Profit & Loss</a></li>
                        <li @if (\Request::is('reports/quick-invoices')) class='active' @endif><a href="{{ route('quick_invoice.report') }}">Quick Invoice</a></li>
                        <li @if (\Request::is('reports/stock')) class='active' @endif><a href="{{ route('stock.report') }}">Stock</a></li>
                    </ul>
                </li>

                <li class="header">Payments Management</li>

                <li @if (\Request::is('other-payment/*') || \Request::is('other-payment')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="fa fa-money"></i><span>Other Paymants</span></a>
                    <ul>
                        <li @if (\Request::is('other-payment/create')) class='active' @endif><a href="{{ route('other-payment.create') }}">Create</a></li>
                        <li @if (\Request::is('other-payment')) class='active' @endif><a href="{{ route('other-payment.index') }}">Manage</a></li>
                    </ul>
                </li>

                <li @if (\Request::is('payment-categories/*') || \Request::is('payment-categories')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="fa fa-money"></i><span>Paymant Categories</span></a>
                    <ul>
                        <li @if (\Request::is('payment-category/create')) class='active' @endif><a href="{{ route('payment-category.create') }}">Create</a></li>
                        <li @if (\Request::is('payment-category')) class='active' @endif><a href="{{ route('payment-category.index') }}">Manage</a></li>
                    </ul>
                </li>

                <li @if (\Request::is('bank/*') || \Request::is('bank')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="fa fa-money"></i><span>Bank</span></a>
                    <ul>
                        <li @if (\Request::is('bank/create')) class='active' @endif><a href="{{ route('bank.create') }}">Create</a></li>
                        <li @if (\Request::is('bank')) class='active' @endif><a href="{{ route('bank.index') }}">Manage</a></li>
                    </ul>
                </li>

                <li @if (\Request::is('branch/*') || \Request::is('branch')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="fa fa-money"></i><span>Branch</span></a>
                    <ul>
                        <li @if (\Request::is('branch/create')) class='active' @endif><a href="{{ route('branch.create') }}">Create</a></li>
                        <li @if (\Request::is('branch')) class='active' @endif><a href="{{ route('branch.index') }}">Manage</a></li>
                    </ul>
                </li>

                <li class="header">Utility Management</li>

                <li @if (\Request::is('printer/*') || \Request::is('printer')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-printer"></i><span>Printer</span></a>
                    <ul>
                        <li @if (\Request::is('printer/create')) class='active' @endif><a href="{{ route('printer.create') }}">Create</a></li>
                        <li @if (\Request::is('printer')) class='active' @endif><a href="{{ route('printer.index') }}">Manage</a></li>
                    </ul>
                </li>
                <li @if (\Request::is('printtype/*') || \Request::is('printtype')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-printer"></i><span>Print Type</span></a>
                    <ul>
                        <li @if (\Request::is('printtype/create')) class='active' @endif><a href="{{ route('printtype.create') }}">Create</a></li>
                        <li @if (\Request::is('printtype')) class='active' @endif><a href="{{ route('printtype.index') }}">Manage</a></li>
                    </ul>
                </li>
                <li @if (\Request::is('unit/*') || \Request::is('unit')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-crop"></i><span>Unit</span></a>
                    <ul>
                        <li @if (\Request::is('unit/create')) class='active' @endif><a href="{{ route('unit.create') }}">Create</a></li>
                        <li @if (\Request::is('unit')) class='active' @endif><a href="{{ route('unit.index') }}">Manage</a></li>
                    </ul>
                </li>
                <li @if (\Request::is('material/*') || \Request::is('material')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-paper-clip"></i><span>Material</span></a>
                    <ul>
                        <li @if (\Request::is('material/create')) class='active' @endif><a href="{{ route('material.create') }}">Create</a></li>
                        <li @if (\Request::is('material')) class='active' @endif><a href="{{ route('material.index') }}">Manage</a></li>
                    </ul>
                </li>
                <li @if (\Request::is('lamination/*') || \Request::is('lamination')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-book-open"></i><span>Lamination</span></a>
                    <ul>
                        <li @if (\Request::is('lamination/create')) class='active' @endif><a href="{{ route('lamination.create') }}">Create</a></li>
                        <li @if (\Request::is('lamination')) class='active' @endif><a href="{{ route('lamination.index') }}">Manage</a></li>
                    </ul>
                </li>
                <li @if (\Request::is('finishing/*') || \Request::is('finishing')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-layers"></i><span>Finishing</span></a>
                    <ul>
                        <li @if (\Request::is('finishing/create')) class='active' @endif><a href="{{ route('finishing.create') }}">Create</a></li>
                        <li @if (\Request::is('finishing')) class='active' @endif><a href="{{ route('finishing.index') }}">Manage</a></li>
                    </ul>
                </li>
                {{-- <li @if (\Request::is('printermaterial/*') || \Request::is('printermaterial')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-link"></i><span>Printer Material</span></a>
                    <ul>
                        <li @if (\Request::is('printermaterial/create')) class='active' @endif><a href="{{ route('printermaterial.create') }}">Create</a></li>
                        <li @if (\Request::is('printermaterial')) class='active' @endif><a href="{{ route('printermaterial.index') }}">Manage</a></li>
                    </ul>
                </li> --}}
                <li @if (\Request::is('format/*') || \Request::is('format')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-equalizer"></i><span>Format</span></a>
                    <ul>
                        <li @if (\Request::is('format/create')) class='active' @endif><a href="{{ route('format.create') }}">Create</a></li>
                        <li @if (\Request::is('format')) class='active' @endif><a href="{{ route('format.index') }}">Manage</a></li>
                    </ul>
                </li>
                <li @if (\Request::is('product/*') || \Request::is('product')) class='active open' @endif>
                    <a href="#role" class="has-arrow"><i class="icon-bag"></i><span>Product</span></a>
                    <ul>
                        <li @if (\Request::is('product/create')) class='active' @endif><a href="{{ route('product.create') }}">Create</a></li>
                        <li @if (\Request::is('product')) class='active' @endif><a href="{{ route('product.index') }}">Manage</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
