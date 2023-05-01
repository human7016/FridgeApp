const preFavorite = document.getElementById("pre-favorite");
const deleteFavorite = document.getElementById("delete-favorite");
const user_id = favorite_off_user.value;
const recipe_id = favorite_off_recipe.value;

function getFavoriteData(){
  console.log(recipe_id);
  console.log(user_id);
  let postData = new FormData; // フォーム方式で送る場
  postData.set('user_id', document.getElementById('favorite_off_user').value); // set()で格納する
  postData.set('recipe_id', document.getElementById('favorite_off_recipe').value); // set()で格納する
  fetch('/get_favorite',{ //第一引数に送り先
    method: 'POST', // GETだとbodyを渡せないためPOSTにする
    headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}, // CSRFトークン対策
    body: postData,
  })
  .then(response => response.json()) // 返ってきたレスポンスをjsonで受け取って次のthenへ渡す
  .then(res => {
  /*--------------------
    PHPからの受取成功
  --------------------*/
    console.log('通信成功');
    if(res){
      deleteFavorite.classList.remove('d-none');
      console.log(res);
    }else{
      preFavorite.classList.remove('d-none');
      console.log(res);
    }
  })
  .catch(error => {
    console.log(error); //エラー表示
  });
}




preFavorite.addEventListener('click',() => {
      /*--------------------
         POST送信
         -------------------*/
    let postData = new FormData; // フォーム方式で送る場
    postData.set('user_id', document.getElementById('favorite_off_user').value); // set()で格納する
    postData.set('recipe_id', document.getElementById('favorite_off_recipe').value); // set()で格納する
    fetch('/put_favorite', { // 第1引数に送り先
    method: 'POST', // メソッド指定
    headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}, // CSRFトークン対策
    body: postData,
  })
  .then(response => response.json()) // 返ってきたレスポンスをjsonで受け取って次のthenへ渡す
  .then(res => {
    console.log(res);
      preFavorite.classList.add('d-none');
      deleteFavorite.classList.remove('d-none');
  })
  .catch(error => {
    console.log(error);
  });
})



deleteFavorite.addEventListener('click',() => {
    let postData = new FormData; // フォーム方式で送る場
    postData.set('user_id', document.getElementById('favorite_in_user').value); // set()で格納する
    postData.set('recipe_id', document.getElementById('favorite_in_recipe').value); // set()で格納する
    fetch('/delete_favorite', { // 第1引数に送り先
    method: 'POST', // メソッド指定
    headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}, // CSRFトークン対策
    body: postData,
  })
  .then(response => response.json()) // 返ってきたレスポンスをjsonで受け取って次のthenへ渡す
  .then(res => {
    console.log(res);
    if(res){
      preFavorite.classList.remove('d-none');
      deleteFavorite.classList.add('d-none');
    }
  })
  .catch(error => {
    console.log(error);
  });
})
getFavoriteData();