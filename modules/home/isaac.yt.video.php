<div id="player"></div>

<script>
	var tag = document.createElement('script');
	tag.src = "https://www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName('script')[0];
	firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

	var player;
	function onYouTubeIframeAPIReady() {
		player = new YT.Player('player', {
			height: '330',
			width: '620',
			videoId: 'wCSb04DOuyM',
			startSeconds: 5,
			playerVars: {
				controls: 0,
				disablekb: 1,
				showinfo: 0	
			},
			events: {
				'onReady': onPlayerReady
			},
			playerVars: {
				'showinfo': 0,
				modestbranding: true,
				'controls': 0, 
				'rel' : 0,
			}
		});
	}

	function onPlayerReady(event) {
		player.setVolume(20);
		//player.playVideo();
	}

	function stopVideo() {
		player.stopVideo();
	}
</script>