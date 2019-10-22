@extends('layouts.app', ['activePage' => 'friends', 'titlePage' => __('phrases.my_friends')])

@section('content')

  <data-list source="{{ route('friends.paginate') }}"></data-list>

  <template id="data-list" slot-scope="modelScope">
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">{{ __('phrases.friends') }}</h4>
              </div>
              <div class="card-body">
                @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <new-friend-modal
                          new-friend-button="{{ __('phrases.buttons.new_friend') }}"
                          available-friends-list-url="{{ route('ajax.available-new-friends') }}"></new-friend-modal>
                </div>
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                    <th>
                      {{ __('phrases.name') }}
                    </th>
                    <th>
                      {{ __('phrases.email') }}
                    </th>
                    <th>
                    </th>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in items" :key="index">
                      <td>@{{ item.name }}</td>
                      <td>@{{ item.email }}</td>
                    </tr>
                    </tbody>
                  </table>

                  @include('shared._pagination')
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
@endsection