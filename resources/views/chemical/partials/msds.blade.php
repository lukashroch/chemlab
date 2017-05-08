<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">{{ trans('msds.title') }}</h4>
      </div>
      <table class="table table-hover">
        <tbody>
        <tr>
          <th>{{ trans('msds.sds') }}</th>
          <td>
            @if(Storage::disk('local')->exists("sds/{$chemical->id}.pdf"))
              <a href="{{ route('chemical.get-sds', ['chemical' => $chemical->id]) }}">
                <span class="fa fa-file-pdf-o"></span> {{ trans('msds.sds.get') }}
              </a>
            @elseif($chemical->brand && $chemical->brand->url_sds)
              {{ trans('msds.sds.not-found') }}
              <a href="{{ url(str_replace('%', $chemical->catalog_id, $chemical->brand->url_sds))  }}" target="_blank">
                <span class="fa fa-file-pdf-o"></span> {{ trans('msds.sds.vendor') }}</a>
            @else
              {{ trans('common.not.specified') }}
            @endif
          </td>
        </tr>
        <tr {!! empty($chemical->symbol) ?: 'style="cursor: pointer;" data-toggle="modal" data-target="#chemical-msds-modal"' !!}>
          <th>{{ trans('msds.symbol_title') }}</th>
          <td>
            @forelse($chemical->symbol as $item)
              {!! Html::image('images/ghs/'.$item.'.gif', $item, ['title' => $item, 'height' => '80', 'width' => '80',
              ]) !!}
            @empty
              {{ trans('common.not.specified') }}
            @endforelse
          </td>
        </tr>
        <tr>
          <th>{{ trans('msds.signal_word') }}</th>
          <td>
            {{ $chemical->signal_word or trans('common.not.specified') }}
          </td>
        </tr>
        <tr>
          <th>{{ trans('msds.h_title') }}</th>
          <td>
            @forelse($chemical->h as $item)
              {{ trans('msds.h.'.$item) }} <br/>
            @empty
              {{ trans('common.not.specified') }}
            @endforelse
          </td>
        </tr>
        <tr>
          <th>{{ trans('msds.p_title') }}</th>
          <td>
            @forelse($chemical->p as $item)
              {{ trans('msds.p.'.$item) }} <br/>
            @empty
              {{ trans('common.not.specified') }}
            @endforelse
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>