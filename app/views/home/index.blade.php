@extends('layouts.layout')

@section('content')
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Recipe Finder</a>
    </div>
    <div class="collapse navbar-collapse">
      <ul class="nav navbar-nav">
        <li class="active"><a href="/">Home</a></li>
        <li><a href="https://github.com/purinda">Source</a></li>
      </ul>
    </div>
  </div>
</div>

<div class="container">

  <div class="starter-template">
    <h1>{{{ isset($recipe) ? 'Recipe Finder suggests "' . $recipe . '"' : 'Recipe Finder' }}}</h1>
    <p class="lead{{{ isset($recipe) ? ' hide' : '' }}}">Upload ingredients and recipes below and <br> get the best suggestion on which meal to cook.</p>
    <div class="row">
      <div class="col-xs-6 col-md-offset-3 col-md-6">&nbsp;</div>
    </div>
    <div class="row{{{ isset($recipe) ? ' hide' : '' }}}">
      <div class="col-xs-6 col-md-offset-3 col-md-6">
        <form enctype="multipart/form-data" role="form" action="/upload" method="post">
          <div class="fileinput fileinput-new input-group" data-provides="fileinput">
            <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
            <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="ingredients-file"></span>
            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
          </div>

          <div class="fileinput fileinput-new input-group" data-provides="fileinput">
            <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
            <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Select file</span><span class="fileinput-exists">Change</span><input type="file" name="recipes-file"></span>
            <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
          <a href="/test" class="btn btn-danger">Test</a>
        </form>
      </div>
    </div>
    <div class="row{{{ isset($recipe) ? '' : ' hide' }}}">
      <div class="col-xs-6 col-md-offset-3 col-md-6">
          <a href="/" class="btn btn-primary">Go back</a>
      </div>
    </div>

  </div>

</div><!-- /.container -->
@stop
