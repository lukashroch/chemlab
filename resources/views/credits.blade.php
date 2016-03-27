@extends('app')

@section('title-content')
  {{ trans('common.credits') }}
@endsection

@section('head-content')
  {{ trans('common.credits') }}
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-heading">The web app has been written by Lukas Hroch.</div>
        <div class="panel-body">
          <p>The author acknowledges the use of following products and express many thanks to all contributors
            of these packages.</p>
        </div>
        <div class="list-group">
          {{ link_to('http://laravel.com/', 'Laravel - PHP Framework', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ link_to('http://jquery.com/', 'jQuery - JS Framework', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ link_to('http://getbootstrap.com/', 'Bootstrap - HTML/CSS/JS
            Framework', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ link_to('https://silviomoreto.github.io/bootstrap-select/', 'Bootstrap Select', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ link_to('http://www.jondmiles.com/bootstrap-treeview', 'Bootstrap Tree View by Jonathan Miles', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ link_to('http://fontawesome.io/', 'Font Awesome Icons', ['class' => 'list-group-item', 'target' => '_blank']) }}
          {{ link_to('http://ggasoftware.com/opensource/ketcher', 'GGA
            Ketcher - Molecular editor', ['class' => 'list-group-item', 'target' => '_blank']) }}
        </div>
      </div>
    </div>
  </div>
@endsection
