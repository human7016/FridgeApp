function useGoogleMap(){

  // 目標地点の緯度(latitude)経度(lngitude)
  const target = { lat: 35.68422624494745, lng: 139.69018599065052 };
  
  // 地図表示
  const map = new google.maps.Map(document.getElementById("map"),{
    zoom: 16,
    center: target,
  });
  
  // 目標地点にマーカーを置く
  const marker = new google.maps.Marker({
    position: target,
    map: map,
  });
}

window.initMap = useGoogleMap;