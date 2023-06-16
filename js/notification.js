/*
notificationManager Class
by Efraim Meulenberg //added by defnot for Efraim Melenberg: <3

Requires jQuery

The notification manager allows you to pop notifications into view using only a few lines of js.
You can specify the container that holds the notifications when creating the class, as well as the screen position:

    var nManager = new notificationManager({container: $( '#container'), position: "topleft" });

Or define them later using: 

    nManager.setContainer( $('#container') );
    nManager.setPosition( "bottomleft" );           //String options: topleft, topright, bottomleft, bottomright

The container can be a jQuery object, or a string used in a jQuery constructor.

Next, to display a notification, use any of the following:

    nManager.addNotification(
    {
        message: "Notification message here",       //string: notification text (Html supported)
        animate: true,                              //boolean: animate the fade in and fade out 
        autoremove: true,                           //boolean: remove this notification after 6 seconds (adds progress bar animation)
        backgroundColor: "#B5D3ED",                 //string: background color of the notification
        progressColor: "#98BFE0"                    //string: color of the progress timer/bar
    });

*/

/*

TODO: Ability to update an existing notification
TODO: Ability to set appear-time
TODO: Ability to remove close button
TODO: Ability to define z-index

*/

function notificationManager (options = {})
{
    this.constructor = function(options)
    {
        //if a container is requested, assign it
        if(options.container)
        {
            this.setContainer(options.container)      
        }

        if(options.position)
        {
            if(this.toString(options.position))
            {
                this.setPosition(options.position);
            }
        }
    };

    this.position = null;
    this.setPosition = function(npos)
    {
        if(this.isString(npos))
        {
            //don't continue without having a container defined
            this.findContainer();

            switch (npos)
            {
                case "topleft":
                    this.position = npos;
                    this.container.removeClass();
                    this.container.addClass('topleft');
                    return true;
                break;

                case "topright":
                    this.position = npos;
                    this.container.removeClass();
                    this.container.addClass('topright');
                    return true;
                break;

                case "bottomleft":
                    this.position = npos;
                    this.container.removeClass();
                    this.container.addClass('bottomleft');
                    return true;
                break;

                case "bottomright":
                    this.position = npos;
                    this.container.removeClass();
                    this.container.addClass('bottomright');
                    return true;
                break;

                default:
                    return false;
                break;
            }
        }
        return false;
    };
    
    /*
    The container is the jQuery element referecing the DOM container
    that holds the notifications
    */
    this.container = false;
    this.setContainer = function(container)
    {
        //if we're given a jQuery object
        if(container instanceof jQuery) 
        { 
            //assign it
            this.container = container; 
        }
        //if we're given a string
        else if(this.isString(container))
        {
            //check if it can find it as DOM element using jQuery
            if($(container).length)
            {
                //assign it as jQuery object
                this.container = $(container);
            }
        }
    };
    

    this.addNotification = function(options = {})
    {
        //don't continue without having a container defined
        this.findContainer();

        if(options.message)
        {
            if(!this.isString(this.position))
            {
                this.position = "bottomright";
                this.container.addClass('bottomright');
            }
            
            /*
            <!-- Example of the DOM we're creating for a notification -->
            <div class="notification">
                <div class="pad">
                    <div class="message">
                        Message here
                    </div>
                    <div class="close">
                        <div class="close-btn">
                        </div>
                    </div>
                </div>
                <div class="progressContainer">
                    <div class="progress"></div>
                </div>
            </div>
            */
            
            //create the dom as exampled above, and add it to the container

            var node = $('<div/>')
                .addClass('notification')
                
            var pad = $('<div/>')
                .addClass('pad')

            var msg = $('<div/>')
                .addClass('message')
                .html(options.message)

            var close = $('<div/>')
                .addClass('close')
                .css('cursor', 'pointer')

            var closeBtn = $('<div/>')
                .addClass('close-btn')

            //add close-notification click functionality
            pad.off('click').on('click', function(e) 
            { 
                //animate when closing; then remove the DOM element entirely
                var n = $(this).parent().parent();
                n.animate({left: '-=50px', opacity: "0"}, "fast", function() { n.remove(); });
            });

            //add close-notification click functionality
            close.off('click').on('click', function(e) 
            { 
                //animate when closing; then remove the DOM element entirely
                var n = $(this).parent().parent();
                n.animate({left: '-=50px', opacity: "0"}, "fast", function() { n.remove(); });
            });

            close.parent().parent().off('click').on('click', function(e) 
            { 
                //animate when closing; then remove the DOM element entirely
                var n = $(this);
                n.animate({left: '-=50px', opacity: "0"}, "fast", function() { n.remove(); });
            });

            var pC = $('<div/>')
                .addClass('progressContainer')

            pC.off('click').on('click', function(e) 
            { 
                //animate when closing; then remove the DOM element entirely
                var n = $(this).parent().parent();
                n.animate({left: '-=50px', opacity: "0"}, "fast", function() { n.remove(); });
            });

            var p = $('<div/>')
                .addClass('progress')

            //if animation is turned on
            if(options.animate===true)
            {
                node.addClass("n-animate-in");
            }

            if(options.autoRemove===true)
            {
                if(options.animate===true)
                {
                    //add the animation class to the notification...
                    node.addClass("n-animate");
                    //...and the progress bar
                    p.addClass('progress-animate');
                    //ensure the node removes itself after the animation finishes
                    node.bind('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function(e) { $(this).remove(); });
                }
                else
                {
                    //...and the progress bar
                    p.addClass('progress-animate');
                    //ensure the node removes itself after the progress-bar animation finishes
                    node.bind('animationend webkitAnimationEnd oAnimationEnd MSAnimationEnd', function(e) { $(this).remove(); });
                }
            }

            if(this.isString(options.backgroundColor))
            {
                node.css('background-color', options.backgroundColor);
            }

            if(this.isString(options.progressColor))
            {
                p.css('background-color', options.progressColor);
            }
            
            pad.append(msg);
            pad.append(close.append(closeBtn));
            
            pC.append(p);

            node.append(pad);
            node.append(pC);

            this.container.append(node);

            return true;
        }
    };

    //define the container/holder of the notifications, or use the document body
    this.findContainer = function()
    {
        //if we don't have a container that holds the notifications
        if(!this.container)
        {
            //look to see if the default container is there
            if($('#notificationsContainer').length)
            {
                this.container = $('#notificationsContainer');
            }
            else
            {
                //and if it isn't, just add the notifications to the body
                this.container = $('body');
            }
        }
    }

    /*
    Janitor functions
    */
    this.isString = function(s) 
    {
       return Object.prototype.toString.call(s) === "[object String]";
    };

    //call the constructor last
    this.constructor(options);
}