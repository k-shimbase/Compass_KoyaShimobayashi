$(function () {

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆検索条件の追加タグをクリックした際に子要素を表示させる
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  $(document).ready(function () {
    $('.search_conditions').click(function () {

      //◇開閉記号active
      $(this).find('i').toggleClass('active');

      //◇同階層のsearch_conditions_innerをslideToggle。
      $(this).siblings('.search_conditions_inner').slideToggle();

    });
  });

  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  // ◆ユーザ情報詳細画面の"選択科目の編集"をクリックした際に子要素を表示させる
  //━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
  $(document).ready(function () {
    $('.subject_edit_btn').click(function () {

      //◇開閉記号active
      $(this).find('i').toggleClass('active');

      //◇同階層のsubject_innerをslideToggle。
      $(this).siblings('.subject_inner').slideToggle();

    });
  });
});
