@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        {{-- Breadcrumb --}}
        @include('layouts.inc.breadcrumb', ['breadcrumb' => [
            'url' => '#',
            'page' => 'Dashboard',
            'current_page' => 'Home',
            'heading' => 'User Dashboard',
        ]])

        <h6>Quick Access</h6>
        
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <div class="d-flex align-items-center">
                            <div class="icon-in-bg bg-indigo text-white rounded-circle"><i class="fa fa-file-text"></i></div>
                            <div class="ml-4">
                                <a href="{{ route('invoice.create') }}">
                                    <span>Invoice Create</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <div class="d-flex align-items-center">
                            <div class="icon-in-bg bg-indigo text-white rounded-circle"><i class="fa fa-archive"></i></div>
                            <div class="ml-4">
                                <a href="{{ route('invoice.index') }}">
                                    <span>Invoice Manage</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <div class="d-flex align-items-center">
                            <div class="icon-in-bg bg-indigo text-white rounded-circle"><i class="fa fa-briefcase"></i></div>
                            <div class="ml-4">
                                <span>Total Revenue</span>
                                <h4 class="mb-0 font-weight-medium">{{ number_format($totalRevenue, 2, '.', ',') }} LKR</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <div class="d-flex align-items-center">
                            <div class="icon-in-bg bg-azura text-white rounded-circle"><i class="fa fa-credit-card"></i></div>
                            <div class="ml-4">
                                <span>Total Invoiced</span>
                                <h4 class="mb-0 font-weight-medium">{{ number_format($totalInvoiced, 2, '.', ',') }} LKR</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <div class="d-flex align-items-center">
                            <div class="icon-in-bg bg-orange text-white rounded-circle"><i class="fa fa-users"></i></div>
                            <div class="ml-4">
                                <span>Today Sale</span>
                                <h4 class="mb-0 font-weight-medium">{{ number_format($todaySale, 2, '.', ',') }} LKR</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="body">
                        <div class="d-flex align-items-center">
                            <div class="icon-in-bg bg-pink text-white rounded-circle"><i class="fa fa-life-ring"></i></div>
                            <div class="ml-4">
                                <span>Today Open Jobs</span>
                                <h4 class="mb-0 font-weight-medium">{{ $openJobs }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-12">
                <h6>My Jobs</h6>
                <div class="table-responsive">
                    <table class="table header-border table-hover table-custom spacing5">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Client</th>
                                <th>Job No</th>
                                <th>Job Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($myJobs as $key => $item)
                                <tr>
                                    <th class="w60">{{ $key+1 }}</th>
                                    <td>{{ $item->client->name }}</td>
                                    <td>{{ $item->job_no }}</td>
                                    <td>{{ $item->finishing_date }} {{ $item->finishing_time }}</td>
                                    <td>
                                        <a href="{{ route('jobcard.index') }}/{{ $item->id }}" class="btn btn-warning">View Job</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">No records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-12">
                <h6>Overdue Invoices</h6>
                <div class="table-responsive">
                    <table class="table header-border table-hover table-custom spacing5">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Client</th>
                                <th>Grand Total</th>
                                <th>Balance Amount</th>
                                <th>Due Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($overDueInvoices as $key => $item)
                                @php
                                    $totalPaid = $item->payments->sum('paid_amount');
                                    $balance = $item->grand_total - $totalPaid;
                                @endphp
                                <tr>
                                    <th class="w60">{{ $key+1 }}</th>
                                    <td>{{ $item->job->client->name }}</td>
                                    <td>{{ number_format($item->grand_total, 2) }}</td>
                                    <td>{{ number_format($balance, 2) }}</td>
                                    <td><span class="badge badge-danger">{{ $item->due_date }}</span></td>
                                    <td>
                                        <a href="{{ route('jobcard.index') }}/{{ $item->job->id }}" class="btn btn-warning">View Job</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">No records found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- <div class="row clearfix">
            <div class="col-lg-6 col-md-6">
                <div class="card">
                    <div class="header">
                        <h2>This Year's Total Revenue</h2>
                        <ul class="header-dropdown dropdown">
                            <li><a href="javascript:void(0);" class="full-screen"><i class="icon-frame"></i></a></li>
                            <li class="dropdown">
                                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0);">Action</a></li>
                                    <li><a href="javascript:void(0);">Another Action</a></li>
                                    <li><a href="javascript:void(0);">Something else</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="body">
                        <small class="text-muted">Sales Performance for Online and Offline Revenue</small>
                        <div id="flotChart" class="flot-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="header">
                        <h2>Volume Vs Service Level</h2>
                    </div>
                    <div class="body text-center">
                        <div id="chart-bar-stacked" style="height: 130px"></div>
                        <hr>
                        <div class="row clearfix">
                            <div class="col-6">
                                <h6 class="mb-0">1,350</h6>
                                <small class="text-muted">Volume</small>
                            </div>
                            <div class="col-6">
                                <h6 class="mb-0">587</h6>
                                <small class="text-muted">Service</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="body">
                        <div id="slider2" class="carousel vert slide" data-ride="carousel" data-interval="1700">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="card-value float-right text-muted"><i class="wi wi-fog"></i></div>
                                    <h3 class="mb-1">12°C</h3>
                                    <div>London</div>
                                </div>
                                <div class="carousel-item">
                                    <div class="card-value float-right text-muted"><i class="wi wi-day-cloudy"></i></div>
                                    <h3 class="mb-1">18°C</h3>
                                    <div>New York</div>
                                </div>
                                <div class="carousel-item">
                                    <div class="card-value float-right text-muted"><i class="wi wi-sunrise"></i></div>
                                    <h3 class="mb-1">37°C</h3>
                                    <div>New Delhi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card">
                    <div class="header">
                        <h2>Customer Satisfaction</h2>
                    </div>
                    <div class="body text-center">
                        <div id="chart-area-spline-sracked" style="height: 130px"></div>
                        <hr>
                        <div class="row clearfix">
                            <div class="col-6">
                                <h6 class="mb-0">$3,095</h6>
                                <small class="text-muted">Last Month</small>
                            </div>
                            <div class="col-6">
                                <h6 class="mb-0">$2,763</h6>
                                <small class="text-muted">This Month</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="body">
                        <div class="card-value float-right text-muted"><i class="icon-bubbles"></i></div>
                        <h3 class="mb-1">102</h3>
                        <div>Messages</div>
                    </div>
                </div>

            </div>
        </div> --}}
    </div>
@endsection
