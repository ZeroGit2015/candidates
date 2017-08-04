function startLoadingAnimation() // - функция запуска анимации
{
  // найдем элемент с изображением загрузки и уберем невидимость:
  var loadingObj = $("#loading");
  loadingObj.show();
 
  // вычислим в какие координаты нужно поместить изображение загрузки,
  // чтобы оно оказалось в середине страницы:
  var centerY = $(window).scrollTop() + ($(window).height() - loadingObj.height())/2;
  var centerX = $(window).scrollLeft() + ($(window).width() - loadingObj.width())/2;
 
  // поменяем координаты изображения на нужные:
  loadingObj.offset({top:centerY, left:centerX});
}
 
function stopLoadingAnimation() // - функция останавливающая анимацию
{
  $("#loading").hide();
}
