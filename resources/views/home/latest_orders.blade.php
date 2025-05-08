<div class="card">
          <div class="card-header border-transparent">
            <h3 class="card-title">{{__('Latest Orders')}}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table m-0">
                <thead>
                <tr>
                  <th>{{ __('ID') }}</th>
                  <th>{{ __('Customer') }}</th>
                  <th>{{ __('Status') }}</th>
                  <th>{{ __('Created At') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($latestOrders as $item)  
                  <tr>
                    <td>
                      @can('orders.show')
                          <a href="{{ route('orders.show', ['order' => $item->id]) }}" class="btn btn-primary btn-sm">
                            {{ $item->id }}
                          </a>
                      @endcan
                    </td>
                    <td>
                       {{ $item->customer_name }}
                  </td>
                    <td>
                        <span class="badge badge-{{ order_status_color($item->status) }}">
                            {{ __(\App\Models\Order::$ORDERSTATUS[$item->status]) }}
                        </span>
                    </td>
                    <td>
                      <div class="sparkbar" data-color="#00a65a" data-height="20">
                        {{ formatDateTimeShow($item->created_at) }}
                      </div>
                    </td>
                  </tr>
                @endforeach
               
                </tbody>
              </table>
            </div>
            <!-- /.table-responsive -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-secondary float-right">{{__('View All Orders')}}</a>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
