{{ Form::open(array('url' => '/search', 'method' => 'post', 'class' => 'navbar-form pull-left')) }}
<div class="input-group">
    <div class="form-group">
        <input type="text" class="form-control" placeholder="Search with name prod..." name="srch" id="srch" value="{{isset($keyword)?$keyword:''}}">
    </div>
    <?php $cat = Categorie::all();?>
    <div class="form-group">
        <select name="category" id="category" class="form-control" title="Select a category for search" >

            <option value="0" @if(isset($category) && $category == 0) selected @endif>All Categories</option>
            @foreach($cat as $c)
                <option value="{{$c['id']}}" @if(isset($category) && $category == $c['id']) selected @endif>{{$c['category_name']}}</option>
            @endforeach
        </select>
    </div>
    <div class="input-group-btn">
        <button type="submit" class="btn btn-default btn-primary" id="search"><i class="glyphicon glyphicon-search"></i></button>
    </div>
</div>

{{Form::close()}}