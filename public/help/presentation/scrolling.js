const scrolling = () => {
    var body = jQuery("html, body"),
        points = [0, 550, 1128, 3747, 5156, 6876],
        i = 1;
    
    setInterval(() => {
        if (i > points.length - 1) i = 0; 
        body.stop().animate({scrollTop: points[i]}, 500, 'swing');
        i++;
    }, 3000)
}

scrolling()
