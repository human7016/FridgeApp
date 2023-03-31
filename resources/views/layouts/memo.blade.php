<div id="screen" class="fixed-top d-none">
  <!-- メモ -->
  <div id="memo" class="container position-fixed d-none">
    <!-- バツマーク -->
    <div class="d-flex flex-row-reverse">
      <i id="cancel" class="fa-solid fa-circle-xmark fa-3x mt-2"></i>
    </div>
    <div class="text-center h1">買い物メモ</div>
    <form action="memo_purchase" method="post">
      @csrf
    @foreach($memos as $memo)
    <div class="mt-3 h5" id="{{$memo->id}}">
      <div class="d-flex flex-row justify-content-between px-2" >
        <div class="col-8">
          <!-- チェックボックス -->
          <div class="form-check">
            @if($memo->on_check)
            <input class="form-check-input check-IO" type="checkbox" name="check[]" value="{{$memo}}" checked="checked">
            @else
            <input class="form-check-input check-IO" type="checkbox" name="check[]" value="{{$memo}}">
            @endif
            <label class="form-check-label" for="flexCheckDefault">
              {{$memo->food}}
            </label>
          </div>
        </div>
        <div class="col-3">
          <div class="d-flex flex-row justify-content-evenly">
            <!-- マイナスマーク -->
            <div><i class="fa-solid fa-square-caret-left sub-btn"></i></div>
            <div class="purchase">{{$memo->purchase}}個</div>
            <!-- プラスマーク -->
            <div><i class="fa-solid fa-square-caret-right add-btn"></i></div>
          </div>
        </div>
        <!-- ゴミ箱 -->
        <div>
          <i class="fa-solid fa-trash-can memo-delete"></i>
        </div>
      </div>
    </div>
    @endforeach
    <div id='dummy'></div>
    <!-- メモ追加フォーム -->
    <div class="d-flex flex-row mt-3">
      <input type="text" class="form-control form-control-sm me-2" id="memo-form" placeholder="豚肉、トマト、etx...">
      <i class="fa-solid fa-circle-plus fa-2x insert-memo"></i>
    </div>
    <input type="submit" value="賞味期限を入力して登録">
    <input type="submit" formaction="to_fridge" value="賞味期限を入力せずに登録">
    </form>
  </div>
</div>

<script>
// メモIO
$(function() {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
  $("#memo_toggle").on("click", function() {
    $("#memo, #screen").removeClass("d-none");
  });
  $("#cancel").on("click", function() {
    $("#memo, #screen").addClass("d-none");
  })

  // メモ追加
  $(".insert-memo").off("click");
  $(".insert-memo").on("click", function(){
    let memo = $("#memo-form").val();
    $.ajax({
      type: "post",
      url: "memo_insert",
      dataType: "json",
      data: {
        item: memo
      }
    })
    .done((res)=>{

      let data = `
      <div class="mt-3 h5" id=`+ (res).id + `>
      <div class="d-flex flex-row justify-content-between px-2" >
        <div class="col-8">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label" for="flexCheckDefault">
              ` + (res).food + `
            </label>
          </div>
        </div>
        <div class="col-3">
          <div class="d-flex flex-row justify-content-evenly">
            <div><i class="fa-solid fa-square-caret-left sub-btn"></i></div>
            <div class="purchase">` + (res).purchase + `個</div>
            <div><i class="fa-solid fa-square-caret-right add-btn"></i></div>
          </div>
        </div>
        <div>
          <i class="fa-solid fa-trash-can memo-delete"></i>
        </div>
      </div>
    </div>
      `;

      $("#dummy").append(data);

      // テキストボックス初期化
      $("#memo-form").val('');
    })
    .fail((error)=>{
      console.log(error.statusText);
    });
  });
  
  // メモ削除
    $(".memo-delete").off("click");
    // 動的に追加した要素にjQuaryをつける(https://qumeru.com/magazine/440)
    $(document).on("click", ".memo-delete", function(){
      let text = $(this).parent().parent().find('.purchase').text();
      console.log('one');
      let id = $(this).parent().parent().parent().attr('id');
      $.ajax({
        type: "post",
        url: "memo_delete",
        dataType: "json",
        data: {
          id: id
        }
      })
      .done((res)=>{
        console.log()
        $(this).parent().parent().parent().addClass('d-none');
      })
      .fail((error)=>{
        console.log(error.statusText);
      });
    });

  // 個数増減
    $(document).on("click", ".sub-btn", function(){
      let container = $(this).parent().parent().parent().parent().parent();
      let id = container.attr("id");
      let purchase = container.find(".purchase").text();
      if(purchase == "0個"){
        $.ajax({
          type: "post",
          url: "memo_delete",
          dataType: "json",
          data: {
            id: id
          }
        })
        .done((res)=>{
          container.addClass('d-none');
        })
        .fail((error)=>{
          console.log(error.statusText);
        });
      } else {
        $.ajax({
          type: "post",
          url: "memo_subtraction",
          dataType: "json",
          data: {
            id: id
          }
        })
        .done((res)=>{
          $(this).parent().parent().find('.purchase').text((res)+'個'); 
        })
        .fail((error)=>{
          console.log(error.statusText);
        });
      }
    });
      
    $(document).on("click", ".add-btn", function(){
      let id = $(this).parent().parent().parent().parent().parent().attr('id');
      $.ajax({
          type: "post",
          url: "memo_addition",
          dataType: "json",
          data: {
            id: id
          }
        })
        .done((res)=>{
          $(this).parent().parent().find('.purchase').text((res)+'個');
        })
        .fail((error)=>{
          console.log(error.statusText);
        });
    });

    // チェックボックスIO
    $(document).on("change",".check-IO",function(){
      let id = $(this).parent().parent().parent().parent().attr('id');
      $.ajax({
          type: "post",
          url: "memo_checked",
          dataType: "json",
          data: {
            id: id
          }
        })
        .done((res)=>{
          console.log(res);
        })
        .fail((error)=>{
          console.log(error.statusText);
        });
    });
});
</script>