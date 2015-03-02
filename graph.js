$(document).ready(function() {

  

   // The code for reading cookies and replacing login and register with hi-user and log-out 
	
    
    log = readCookie('log-statue-cookie');
	user = readCookie('log-in-cookie');
    var logInError = readCookie('log-in-error-cookie');
	var registerMessage = readCookie('register-Message-cookie');
	var removeGraph = readCookie('remove-graph-cookie');
	if ( logInError == 1){ alert('Please enter a correct username or password.');}
	if ( registerMessage == 1){ alert('Now you can log in to your account.');} 
	if ( registerMessage == 0){alert('It seems you have been registered by the same e-mail or username.');}
	if ( removeGraph == 1){alert('The graph has been removed from the database.');}
	 
	//user = decodeURIComponent(escape(user));
	user = decodeURIComponent(user);
	
	if(log==1){
			        var myNode = document.getElementById("log");
                    while (myNode.firstChild) {
                        myNode.removeChild(myNode.firstChild);   
                        }
						
					var myNode = document.getElementById("reg");
                    while (myNode.firstChild) {
                        myNode.removeChild(myNode.firstChild);
					        }		
			
					var paraHi = document.createElement("a");
					paraHi.setAttribute('id', 'hiUser'); 
					paraHi.setAttribute('class', 'btn btn-lg');
					var nodeHi;
					nodeHi = document.createTextNode(user);
					paraHi.appendChild(nodeHi);

					var elementHi = document.getElementById("log");
					elementHi.appendChild(paraHi);
					
					//$('#hiUser').append('<span class="glyphicon glyphicon-user"></span>');
					
					var para = document.createElement("a");
					para.setAttribute('href', 'log-out-engine.php');
					para.setAttribute('id', 'logOut');
					para.setAttribute('class', 'btn btn-lg');
					var node;
					if(language=='en') node = document.createTextNode("Log out");
					if(language=='man') node = document.createTextNode("注销");
					if(language=='span') node = document.createTextNode("finalizar la sesión");
					if(language=='frc') node = document.createTextNode("déconnecter");
					para.appendChild(node);

					var element = document.getElementById("reg");
					element.appendChild(para);
					document.getElementById("save-as-submit").setAttribute('data-target', '#saveAsModal');
					document.getElementById("save-submit").setAttribute('data-target', '#saveRejectModal');
					
					//document.getElementById("log").style.marginLeft = "800px";
					
    }	
	//The end of the code for cookies---
	
	
    var color = 'blue';
	
    var graph = new joint.dia.Graph;

    var paper = new joint.dia.Paper({
	    //#myholder is the way we call the html element with ID
        el: $('#myholder'),
        width: 1500,
        height: 700,
        model: graph
    });
    
	
    // Create a custom element model. For creating a model with some buttons and other html tags we have to use  joint.shapes.html
    // ------------------------
    joint.shapes.html = {};
	
	
	//Here we have the general definition of the first element's model
	//------------------------------------------------------
    joint.shapes.html.Element = joint.shapes.basic.Generic.extend(_.extend({}, joint.shapes.basic.PortsModelInterface, {
        markup: '<g class="rotatable"><g class="scalable"><rect class = "myrect"/></g><g class="inPorts"/><g class="outPorts"/></g>',
        portMarkup: '<g class="port<%= id %>"><circle class="port-body"/></g>',
        defaults: joint.util.deepSupplement({
            type: 'html.Element',
            size: { width: 200, height: 110 },
            inPorts: [],
            outPorts: [],
			color: '#94DBFF',
			widthTextarea: 150,
			heightTextarea: 60,
			widthColorEdit: 200,
			heightColorEdit: 100,
			topIn: 87,
            attrs: {
                '.': { magnet: true},
                rect: {
                    stroke: 'none', 'fill-opacity': 0, width: 300, height: 210
                },
                circle: {
                    r: 6, //circle radius
                    magnet: true,
					left:0,
                    stroke: 'gray'
                },

                '.inPorts circle': { fill: 'gray', magnet: 'passive', type: 'input', y: 0},
                '.outPorts circle': { fill: 'gray', type: 'output', magnet: 'passive' }
            }
        }, joint.shapes.basic.Generic.prototype.defaults),
        getPortAttrs: function (portName, index, total, selector, type) {

            var attrs = {};
            var portClass = 'port' + index;
            var portSelector = selector + '>.' + portClass;
            var portCircleSelector = portSelector + '>circle';
            attrs[portCircleSelector] = { port: { id: portName || _.uniqueId(type), type: type } };
            attrs[portSelector] = { ref: 'rect', 'ref-x': (index + 1) * (0.5 / total)};
            if (selector === '.outPorts') { 
			    attrs[portSelector]['ref-dy'] = 4; 
			}
            return attrs;
        }
    }));
    
		

   // Create a custom view for that element that displays an HTML div above it.
 //--------------------
   
    joint.shapes.html.ElementView = joint.dia.ElementView.extend({
        //Here we have the detailed html tags on the element
        template: [
            '<div class="html-element">',
			'<label class="color-edit"></label>',
            '<button class="delete">x</button>',
			'<button class="out">A</button>',
			'<button class="in">A</button>',
			'<button class="green"></button>',
			'<button class="red"></button>',
			'<button class="yellow"></button>',
            '<span class="lbl" value=""></span>', 
            '<textarea class="txt" type="text" id ="txarea" placeholder="Start writing"></textarea>',
            '</div>'
        ].join(''),
    //Here we start put some code for the html tags above so they function properly on every element we instantiate from the predefined model
    initialize: function() {
        _.bindAll(this, 'updateBox');
        joint.dia.ElementView.prototype.initialize.apply(this, arguments);

        this.$box = $(_.template(this.template)());
        // Prevent paper from handling pointerdown.
        this.$box.find('input').on('mousedown click', function(evt) { evt.stopPropagation(); });
        
		//This is for measuring the size of the box to be able resize it later
        this.$ruler = $('<span>', { style: 'visibility: hidden; white-space: pre' });
        $(document.body).append(this.$ruler);
		
		
		
        // This is an example of reacting on the input change and storing the input data in the cell model and resizing the element.
        this.$box.find('textarea').on('input', _.bind(function(evt) {

            var val = $(evt.target).val();
            this.model.set('textarea', val);
			

            this.$ruler.html(val);
            var width = this.$ruler[0].offsetWidth;
            var height = this.$ruler[0].offsetHeight;
			var area = width * height;
			//width = Math.sqrt((3 * area) / 2);
			//height = ((2 * width)/3);
			height = area/150;
			width = 150;
			if((area > 9000)){
            this.model.set('size', { width: width + 50 , height: height + 80 });
			
			this.$box.find('textarea').css({ width: width  , height: height + 30});
			this.model.set('widthTextarea', width);
			this.model.set('heightTextarea', height + 30);
			
			this.$box.find('.color-edit').css({width: width + 50 , height: height + 80});
			this.model.set('widthColorEdit', width + 50);
			this.model.set('heightColorEdit', height + 80);
			
			this.$box.find('.in').css({ top: height + 75});
			this.model.set('topIn', height + 75);
			paper.fitToContent( 100, 100, 50, 'any'); 
			
            }
			
			
        }, this));
		
		
		
        this.$box.find('.color-edit').css({background : this.model.get('color')});
		this.$box.find('textarea').css({ width: this.model.get('widthTextarea')  , height: this.model.get('heightTextarea')});
		this.$box.find('.color-edit').css({width: this.model.get('widthColorEdit')  , height: this.model.get('heightColorEdit')});
		this.$box.find('.in').css({ top: this.model.get('topIn')});
		this.$box.find('textarea').text(this.model.get('span'));
        
		//For turning the box to green
		this.$box.find('.green').on('click', _.bind(function() {
		
		    
			this.$box.find('.color-edit').css({background : '#CCE680'});
			this.model.set('color', '#CCE680');
		
		}, this));
		
		
		//For turning the box to red
		this.$box.find('.red').on('click', _.bind(function() {
		
		    this.$box.find('.color-edit').css({ background: '#F0B2B2'});
			this.model.set('color', '#F0B2B2');
		
		}, this));
		
		//For turning the box to yellow
		this.$box.find('.yellow').on('click', _.bind(function() {
		
		    this.$box.find('.color-edit').css({ background: '#FFFF99'});
			this.model.set('color', '#FFFF99');
		
		}, this));
		
		
		//Change opacity of delete button and textarea to 1 by click on the textarea
		this.$box.find('textarea').on('click', _.bind(function() {
		
		    this.$box.find('.delete').css({ opacity:1 });
			this.$box.find('textarea').css({ opacity:1 });
			
			this.$box.updateBox();
		
		}, this));
		
		
		//Change opacity of delete button and textarea to 0 by click on the paper area (blur is an event for when you lose focus by clicking on somewhere else)
		this.$box.find('textarea').on('blur', _.bind(function() {
		
		    this.$box.find('.delete').css({ opacity:0 });
			this.$box.find('textarea').css({ opacity:0 });
			
		
		}, this));
		
		var elNumIn = 0;
	    
		
		//For creating another element alongside the links by click on the lower button (.in)
		this.$box.find('.in').on('click', _.bind(function(cellView, evt,x, y) {
		
		    var x = this.$box.find('.in').offset().left;
			var y = this.$box.find('.in').offset().top;
			
			//finding new x and y creating boxes so they don't cover each other
			var xNewEl2;
			var yNewEl2;
			var xNewEl3;
			var yNewEl3;
			
			if (elNumIn == 0){
			    var xNewEl2 = x - 11;
			    var yNewEl2 = y + 55;
			    var xNewEl3 = x - 96 ;
			    var yNewEl3 = y + 120; 
			} else {
			
			    //xNewEl2 = x - 11 - (100*elNumIn)-20;
				xNewEl2 = (x - 96)-((y + 120)*(95*elNumIn)/(y + 55)) - (95*elNumIn) + 85;
			    yNewEl2 = y + 55;
			    xNewEl3 = (x - 96)-((y + 120)*(95*elNumIn)/(y + 55)) - (95*elNumIn) ;
			    yNewEl3 = y + 120;
			
			}
			
  
		    var cell = cellView.model;
            
		
             
			var el2 = new joint.shapes.html.myElement({ 
                position: { x: xNewEl2 , y: yNewEl2 }, 
                size: { width: 30, height: 30 },
                inPorts: ['in'],
                outPorts: ['out'],
	            attrs: {
                '.label': { text: 'Model', 'ref-x': .4, 'ref-y': .2 },
                    rect: { fill: '#2ECC71' },
                    '.inPorts circle': { fill: 'gray', magnet: 'passive' },
                    '.outPorts circle': { fill: 'gray', magnet: 'passive' }
                }
            });
			
            var link1 = new joint.shapes.html.Link({
                source: { id: this.model.id, port: 'out' },
                target: { id: el2.id, port: 'in' }
            });
	        
			
	        var el3 = new joint.shapes.html.Element({ 
                position: { x: xNewEl3 , y: yNewEl3 }, 
                size: { width: 200, height: 100 },
                inPorts: ['in'],
                outPorts: ['out'],
	            attrs: {
                '.label': { text: 'Model', 'ref-x': .4, 'ref-y': .2 },
                    rect: { fill: '#2ECC71' },
                    '.inPorts circle': { fill: 'gray', magnet: 'passive' },
                    '.outPorts circle': { fill: 'gray', magnet: 'passive' }
                },
                textarea: ''
            });
		
			     
			
	        var link2 = new joint.shapes.html.Link1({
                source: { id: el2.id, port: 'out' },
                target: { id: el3.id, port: 'in' }
            });
            
	        graph.addCells([el2, link1]);
	        graph.addCells([el3, link2]);
    
	        paper.findViewByModel(link1).options.interactive = false;
			paper.findViewByModel(link2).options.interactive = false;
			
			/*if (graph.findModelsFromPoint(x - 105 , y + 100) != NULL){
			console.log('hi');
	         }*/
			//paper.fitToContent( 1500, 700, 50, 100);
			
			//paper.fitToContent( 1500, 700, 50, 'negative');
			paper.fitToContent( 100, 100, 50, 'any');
			
			
			elNumIn += 1;
			
		    }, this));
		
        
        //For creating another element alongside the links by click on the upper button (.out)	

        var elNumOut = 0;        
		
		this.$box.find('.out').on('click', _.bind(function(cellView, evt,x, y) {
		
		    var x = this.$box.find('.out').offset().left;
			var y = this.$box.find('.out').offset().top;
			
			var xNewEl2;
			var yNewEl2;
			var xNewEl3;
			var yNewEl3;
			
			if (elNumOut == 0){
			    var xNewEl2 = x - 10;
			    var yNewEl2 = y - 65;
			    var xNewEl3 = x - 95;
			    var yNewEl3 = y - 215; 
			} else {
			
			    //xNewEl2 = x - 10 - (150*elNumOut); 
				xNewEl2 = (x - 95)-((y - 215)*(150*elNumOut)/(y - 65))- (150*elNumOut) + 85;
			    yNewEl2 = y - 65;
			    xNewEl3 = (x - 95)-((y - 215)*(150*elNumOut)/(y - 65))- (150*elNumOut);
			    yNewEl3 = y - 215;
			
			}
			
		    var cell = cellView.model;
  		
			var el2 = new joint.shapes.html.myElement({ 
                position: { x: xNewEl2 , y: yNewEl2 }, 
                size: { width: 30, height: 30 },
                inPorts: ['in'],
                outPorts: ['out'],
	            attrs: {
                '.label': { text: 'Model', 'ref-x': .4, 'ref-y': .2 },
                    rect: { fill: '#2ECC71' },
                    '.inPorts circle': { fill: 'gray', magnet: 'passive' },
                    '.outPorts circle': { fill: 'gray', magnet: 'passive' }
                }
            });
               
			
            var link1 = new joint.shapes.html.Link1({
                source: { id: el2.id, port: 'out' } ,
                target: { id: this.model.id, port: 'in' }
            });
	
	        var el3 = new joint.shapes.html.Element({ 
                position: { x: xNewEl3 , y: yNewEl3 }, 
                size: { width: 200, height: 100 },
                inPorts: ['in'],
                outPorts: ['out'],
	            attrs: {
                '.label': { text: 'Model', 'ref-x': .4, 'ref-y': .2 },
                    rect: { fill: '#2ECC71' },
                    '.inPorts circle': { fill: 'gray', magnet: 'passive' },
                    '.outPorts circle': { fill: 'gray', magnet: 'passive' }
                },
                textarea: ''
            });
	        
	        
	        var link2 = new joint.shapes.html.Link({
                source: { id: el3.id, port: 'out' },
                target: { id: el2.id, port: 'in' }
            });

	        graph.addCells([el2, link1]);
	        graph.addCells([el3, link2]);
    
	        paper.findViewByModel(link1).options.interactive = false;
			paper.findViewByModel(link2).options.interactive = false;
	
			//paper.fitToContent( 1500, 700, 20, 20);
			
			//paper.fitToContent( 1500, 700, 50, 'negative');
			paper.fitToContent( 100, 100, 50, 'any');
			
		    
			elNumOut += 1;
			
		    }, this));	
		
        this.$box.find('.delete').on('click', _.bind(this.model.remove, this.model));
        // Update the box position whenever the underlying model changes.
        this.model.on('change', this.updateBox, this);
        // Remove the box when the model gets removed from the graph.
        this.model.on('remove', this.removeBox, this);

        this.updateBox();

        this.listenTo(this.model, 'process:ports', this.update);
        joint.dia.ElementView.prototype.initialize.apply(this, arguments);
    },


     render: function() {
        joint.dia.ElementView.prototype.render.apply(this, arguments);
        this.paper.$el.prepend(this.$box);
        // this.paper.$el.mousemove(this.onMouseMove.bind(this)), this.paper.$el.mouseup(this.onMouseUp.bind(this));
        this.updateBox();
        return this;
    },

    renderPorts: function () {
        var $inPorts = this.$('.inPorts').empty();
        var $outPorts = this.$('.outPorts').empty();

        var portTemplate = _.template(this.model.portMarkup);

        _.each(_.filter(this.model.ports, function (p) { return p.type === 'in' }), function (port, index) {

            $inPorts.append(V(portTemplate({ id: index, port: port })).node);
        });
        _.each(_.filter(this.model.ports, function (p) { return p.type === 'out' }), function (port, index) {

            $outPorts.append(V(portTemplate({ id: index, port: port })).node);
        });
    }, 

    update: function () {

        // First render ports so that `attrs` can be applied to those newly created DOM elements
        // in `ElementView.prototype.update()`.
        this.renderPorts();
        joint.dia.ElementView.prototype.update.apply(this, arguments);
    },

    updateBox: function() {
        // Set the position and dimension of the box so that it covers the JointJS element.
        var bbox = this.model.getBBox();
        // Example of updating the HTML with a data stored in the cell model.
         
        this.$box.find('span').text(this.model.get('textarea'));
		this.$box.find('textarea').text(this.model.get('textarea'));
		
		/*if(this.$box.find('span').text == '' ) {
		    this.$box.find('textarea').text('Start writing');
		}
		
		if(!(this.$box.find('span').text == '' )){
		this.$box.find('textarea').text(this.model.get('textarea'));
		    }   */
		
		//this.$box.find('textarea').text(this.model.get('span'));
		
        this.$box.css({ width: bbox.width, height: bbox.height, left: bbox.x, top: bbox.y, transform: 'rotate(' + (this.model.get('angle') || 0) + 'deg)' });
    },
    removeBox: function(evt) {
        this.$ruler.remove();
        this.$box.remove();
    }
});

//Create the second custom element

joint.shapes.html.myElement = joint.shapes.basic.Generic.extend(_.extend({}, joint.shapes.basic.PortsModelInterface, {
        markup: '<g class="rotatable"><g class="scalable"><rect class = "myrect"/></g><g class="inPorts"/><g class="outPorts"/></g>',
        portMarkup: '<g class="port<%= id %>"><circle class="port-body"/></g>',
        defaults: joint.util.deepSupplement({
            type: 'html.myElement',
            size: { width: 20, height: 20 },
            inPorts: [],
            outPorts: [],
			color: '#94DBFF',
            attrs: {
                '.': { magnet: true},
                rect: {
                    stroke: 'none', 'fill-opacity': 0, width: 20, height: 20
                },
                circle: {
                    r: 0, //circle radius
                    magnet: true,
					left:0,
                    stroke: 'gray'
                },

                '.inPorts circle': { fill: 'gray', magnet: 'passive', type: 'input', y: 0},
                '.outPorts circle': { fill: 'gray', type: 'output', magnet: 'passive' }
            }
        }, joint.shapes.basic.Generic.prototype.defaults),
        getPortAttrs: function (portName, index, total, selector, type) {

            var attrs = {};
            var portClass = 'port' + index;
            var portSelector = selector + '>.' + portClass;
            var portCircleSelector = portSelector + '>circle';
            attrs[portCircleSelector] = { port: { id: portName || _.uniqueId(type), type: type } };
            attrs[portSelector] = { ref: 'rect', 'ref-x': (index + 1) * (0.5 / total)};
            if (selector === '.outPorts') { 
			    attrs[portSelector]['ref-dy'] = -20; 
			}
            return attrs;
        }
    }));
    
		

   // Create a custom view for that element that displays an HTML div above it.
 //--------------------
   
    joint.shapes.html.myElementView = joint.dia.ElementView.extend({
        //Here we have the detailed html tags on the element
        template: [
            '<div class="html-element">',
			'<button class="colorEditMiddle"></button>',
            '<button class="deleteMiddle">x</button>',
			'<button class="intersection"></button>',
			'<button class="redMiddle"></button>',
			'<button class="yellowMiddle"></button>',
			'<button class="greenMiddle"></button>',
            '</div>'
        ].join(''),
    //Here we start put some code for the html tags above so they function properly on every element we instantiate from the predefined model
    initialize: function() {
        _.bindAll(this, 'updateBox');
        joint.dia.ElementView.prototype.initialize.apply(this, arguments);

        this.$box = $(_.template(this.template)());
        // Prevent paper from handling pointerdown.
        this.$box.find('input').on('mousedown click', function(evt) { evt.stopPropagation(); });
        
		//this.listenTo(this.model, 'change:color', function() {
            this.$box.find('.colorEditMiddle').css({background : this.model.get('color')});
        //})
		
		this.$box.find('.greenMiddle').on('click', _.bind(function() {
		    
			this.$box.find('.colorEditMiddle').css({background : '#CCE680'});
			this.model.set('color', '#CCE680');
			
		}, this));
		
		this.$box.find('.redMiddle').on('click', _.bind(function() {
		
			this.$box.find('.colorEditMiddle').css({background : '#F0B2B2'});
			this.model.set('color', '#F0B2B2');
			
		}, this));
		
		this.$box.find('.yellowMiddle').on('click', _.bind(function() {
		
			this.$box.find('.colorEditMiddle').css({background : '#FFFF99'});
			this.model.set('color', '#FFFF99');
			
		}, this));
		
		
		
		this.$box.find('.colorEditMiddle').on('click', _.bind(function() {
		    var color = this.$box.find('.colorEditMiddle').style.background();
			if(color == '#33CC33' ) {this.$box.find('.colorEditMiddle').css({background : '#D11919'}); }
			if(color == '#D11919' ) {this.$box.find('.colorEditMiddle').css({background : '#FF9933'});}
			if(color == '#FF9933' ) {this.$box.find('.colorEditMiddle').css({background : '#33CC33'});}
            if(color == '#94DBFF' ) {this.$box.find('.colorEditMiddle').css({background : '#33CC33'});}			
			
		}, this));
		
		
		
		//Change opacity of delete button and textarea to 1 by click on the textarea
		this.$box.find('html-element').on('click', _.bind(function() {
		
		    this.$box.find('.deleteMiddle').css({ opacity:1 });
			this.$box.find('.intersection').css({ opacity:1 });
			
		
		}, this));
		
		
		//Change opacity of delete button and textarea to 0 by click on the paper area (blur is an event for when you lose focus by clicking on somewhere else)
		this.$box.find('html-element').on('blur', _.bind(function() {
		
		    this.$box.find('.deleteMiddle').css({ opacity:0 });
			this.$box.find('.intersection').css({ opacity:0 });
			
		
		}, this));
		
		//The counter
		var elNumIntersection = 1;
		
		this.$box.find('.intersection').on('click', _.bind(function(cellView, evt,x, y) {
		
		    var x = this.$box.find('.intersection').offset().left;
			var y = this.$box.find('.intersection').offset().top;
			
			
			
			//var xNew = x + 120;
			//var yNew = y + 60;
			var xNew;
			var yNew;
			
			    xNew = x - 80 + elNumIntersection*204 - 23;
			    yNew = y + 64;
			   
			
		    var cell = cellView.model;
          

	        var el = new joint.shapes.html.Element({ 
                position: { x: xNew , y: yNew }, 
                size: { width: 200, height: 100 },
                inPorts: ['in'],
                outPorts: ['out'],
	            attrs: {
                '.label': { text: 'Model', 'ref-x': .4, 'ref-y': .2 },
                    rect: { fill: '#2ECC71' },
                    '.inPorts circle': { fill: 'gray', magnet: 'passive' },
                    '.outPorts circle': { fill: 'gray', magnet: 'passive' }
                },
                textarea: ''
            });
	        
			
	
	        var link = new joint.shapes.html.Link1({
                source: { id: this.model.id, port: 'out' },
                target: { id: el.id, port: 'in' }
            });

	        graph.addCells([el, link]);
    
	        paper.findViewByModel(link).options.interactive = false;
			
			paper.fitToContent( 1500, 700, 20, 20);
			
			elNumIntersection += 1;
		
		
		}, this));
		
		
        this.$box.find('.deleteMiddle').on('click', _.bind(this.model.remove, this.model));
        // Update the box position whenever the underlying model changes.
        this.model.on('change', this.updateBox, this);
        // Remove the box when the model gets removed from the graph.
        this.model.on('remove', this.removeBox, this);

        this.updateBox();

        this.listenTo(this.model, 'process:ports', this.update);
        joint.dia.ElementView.prototype.initialize.apply(this, arguments);
    },


     render: function() {
        joint.dia.ElementView.prototype.render.apply(this, arguments);
        this.paper.$el.prepend(this.$box);
        //this.paper.$el.mousemove(this.onMouseMove.bind(this)), this.paper.$el.mouseup(this.onMouseUp.bind(this));
        this.updateBox();
        return this;
    },

    renderPorts: function () {
        var $inPorts = this.$('.inPorts').empty();
        var $outPorts = this.$('.outPorts').empty();

        var portTemplate = _.template(this.model.portMarkup);

        _.each(_.filter(this.model.ports, function (p) { return p.type === 'in' }), function (port, index) {

            $inPorts.append(V(portTemplate({ id: index, port: port })).node);
        });
        _.each(_.filter(this.model.ports, function (p) { return p.type === 'out' }), function (port, index) {

            $outPorts.append(V(portTemplate({ id: index, port: port })).node);
        });
    }, 

    update: function () {

        // First render ports so that `attrs` can be applied to those newly created DOM elements
        // in `ElementView.prototype.update()`.
        this.renderPorts();
        joint.dia.ElementView.prototype.update.apply(this, arguments);
    },

    updateBox: function() {
        // Set the position and dimension of the box so that it covers the JointJS element.
        var bbox = this.model.getBBox();
        // Example of updating the HTML with a data stored in the cell model.
       
        this.$box.css({ width: bbox.width, height: bbox.height, left: bbox.x, top: bbox.y, transform: 'rotate(' + (this.model.get('angle') || 0) + 'deg)' });
    },
    removeBox: function(evt) {
        this.$box.remove();
    }
}); 


// Create link view models.

joint.shapes.html.Link = joint.dia.Link.extend({

                defaults: {
                    type: 'html.Link',
                    attrs: {
                        '.connection': { 'stroke-width': 2, stroke: 'gray' },
                        '.marker-source': { fill: 'gray',stroke: 'gray', d: 'M 10 0 L 0 5 L 10 10 z' }
                         },
                  
                },
				validateConnection: function(cellViewS, magnetS, cellViewT, magnetT, end, linkView) {
                 // Prevent loop linking
                    return (magnetS !== magnetT);
                },
                 
            });
			
	joint.shapes.html.Link1 = joint.dia.Link.extend({

                defaults: {
                    type: 'html.Link',
                    attrs: {
                        '.connection': { 'stroke-width': 2, stroke: 'gray' }
                           },
                     },
				validateConnection: function(cellViewS, magnetS, cellViewT, magnetT, end, linkView) {
                 // Prevent loop linking
                    return (magnetS !== magnetT);
                },
                  });	
			

// Create JointJS elements and add them to the graph as usual.
// -----------------------------------------------------------

var el1 = new joint.shapes.html.Element({ 
    position: { x: 600, y: 300 }, 
    size: { width: 200, height: 100 },
    inPorts: ['in'],
    outPorts: ['out'],
	attrs: {
        '.label': { text: 'Model', 'ref-x': .4, 'ref-y': .2 },
        rect: { fill: '#2ECC71' },
        '.inPorts circle': { fill: 'gray' },	
        '.outPorts circle': { fill: 'gray' }
    },
    textarea: ''
  });
  
  graph.addCells([el1]);
  

        var title = '';
		var countTitleSaveAs = '';
		var countTitleSave = '';
        document.getElementById("save-submit").onclick = function() {saveGraph()};
		
		function saveGraph(){
		   
		   document.getElementById("title-save").value = title;
		   var jso1 = graph.toJSON();
           var strjs1 = JSON.stringify(jso1);
		   
		   document.getElementById("graph-txt-save").value = strjs1;
		   document.getElementById("count-save").value = countTitleSave;
		    
		}
		
		document.getElementById("print").onclick = function() {alert("hi")};
		
		document.getElementById("save-as-submit").onclick = function() {saveAsGraph()};

       function saveAsGraph() {
	       var jso = graph.toJSON();
           var strjs = JSON.stringify(jso);
         
		   document.getElementById("graph-txt").value = strjs;
		   //document.getElementById("save-submit").setAttribute('data-target', '#saveModal');
        }
		

       
	    
		// Access the json created by open-engine.php for showing the title of graph under open sub-menu
		
	    $.getJSON('http://magic.philosophy.ubc.ca/argumentMapping/open-engine.php', function(data) {
            var items1 = [];
			var items2 = [];
			$.ajaxSetup({ scriptCharset: "utf-8" , contentType: "application/json; charset=utf-8"});
            var count = 0;
            $.each(data.graphs, function(i, graph) {
			    count += 1;
			    var str_q = JSON.stringify(graph.title);
					var str_w = str_q.replace(/"/g, '');
				console.log(graph.graph);
				
                
				$('#myTable').append('<tr id = "open-click"><td><a href="#" class = "btn-default ' + str_w + '" id = "' + count + '">' + str_w + '</a></td><td><a href = "#" class = "btn-default ' + str_w + '" id="remove ' + count + '" data-toggle="modal" data-target="#removeModal"><span class="glyphicon glyphicon-trash"></span></a></td></tr>');
				
				});
			countTitleSaveAs =  count ;
			
			
			// After appending the titles of the graph to open sub-menu we loop through
			//them to create a click event for opening the graphs
			var temp = '';
			for (var i = 1; i < count +1; i++){
			    temp =  i;
			    document.getElementById(temp).onclick = (function(temp) {
				
				
                    return function (e) { 
                        countTitleSave = temp;
						var str_g = "";
			            graph.clear();
			            var tit = document.getElementById(temp).innerHTML;
	                    $.each(data.graphs, function(i, graph) {
							
			                if (graph.title == tit){
			                    str_g =  graph.graph;
				            }
					
                        });
				        title = tit;
						console.log(str_g);
				        graph.fromJSON(JSON.parse(str_g));
						document.getElementById("save-submit").setAttribute('data-target', '#saveModal');
					    
						
						
                    };
						
                })(i);
				
				var tempRe = "remove " + i;
 					document.getElementById(tempRe).onclick = (function(tempRe) {
				
				
                    return function (e) { 
					    document.getElementById("closeRemove").click();
                        document.getElementById("title-remove").value = (document.getElementById(tempRe).className).replace("btn-default ","");
						
					};
					
				})(i);	
			}
			
			savedGraphTitle = 0;
			savedAsGraphTitle = 0;
			savedGraphTitle = readCookie('saved-graph-cookie');
			savedAsGraphTitle = readCookie('saved-as-graph-cookie');
			
			document.cookie="saved-graph-cookie=;";
			document.cookie="saved-as-graph-cookie=;";
         
            if (!(savedGraphTitle == 0)) {
			    openGraph(savedGraphTitle);
				alert('The graph has been saved.');
				document.getElementById("save-submit").setAttribute('data-target', '#saveModal');
			}			
			
			else if (savedAsGraphTitle == 1) {
			    openGraph(countTitleSaveAs);
				alert('The graph has been saved.');
				document.getElementById("save-submit").setAttribute('data-target', '#saveModal');
			}	
			
			//A function for opening a specific graph
			function openGraph(graphT)
			{
			    document.getElementById(graphT).click();
			   
			}
			
			
        });
		
		/*var tempRe = '';
			for (var j = 1; j < count +1; j++){
			    tempRe = "remove";
				
			    document.getElementById(tempRe).onclick = (function() {
				
				
                    return function () { 
					    alert("hi");
                        document.getElementById("title-remove").value = document.getElementById(tempRe).className;
						document.getElementById("closeRemove").click();
						
					};    
                })(j);
			}*/
		
	
});