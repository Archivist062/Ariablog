TreeMe = {
  CurrentTree: {
  },
  TreeGen: function (JSONdt) {
    this.CurrentTree = JSON.parse(JSONdt);
    alert(TreeMe.Display.Tree.Plain(this.CurrentTree, 0));
  },
  TreeDeGen: function () {
    return JSON.stringify(this.CurrentTree);
  },
  Display:
  {
    Tree: {
      Plain: function (Tree,nest = 0) {
		var nested = nest;
        var disp = '';
        for (var i = 0; i < nested; ++i) {
          disp += ' ';
        }
        disp += '\\_';
        disp += Tree.name + '\n';
		var i=1;
        while(typeof Tree.childs[i.toString()] != 'undefined')
		{
          disp += this.Plain(Tree.childs[i.toString()], nested + 1);
		  i++;
        }
        return disp;
      },
	  HTML: function (Tree, nest = 0)
	  {
        var disp  =Tree.name;
        disp +=  '<ul>';
		var i=1;
        while(typeof Tree.childs[i.toString()] != 'undefined')
		{
			disp += "<li>";
			disp += this.HTML(Tree.childs[i.toString()]);
			disp += "</li>";
			i++;
        }
        disp += '</ul>';
        return disp;
	  }
    },
    Content: {
		Plain: function (Tree,target) {
        var disp = '';
		var i=1;
        while(typeof Tree.childs[i.toString()] != 'undefined')
		{
			disp += this.Plain(Tree.childs[i.toString()], target);
			i++;
        }
        return disp;
      }
    }
  }
};
HTTREE = { 
	Fill : function()
	{
		TreeMe.TreeGen(document.getElementById("TreeMeData").innerHTML);
		document.getElementById("TreeDisplay").innerHTML = "<ul><li>" + TreeMe.Display.Tree.HTML(TreeMe.CurrentTree,0) + "</li></ul>";
	}
};
HTCONTENT = {
	Fill : function(target)
	{
		TreeMe.TreeGen(document.getElementById("TreeMeData").innerHTML);
		document.getElementById("ContentDisplay").innerHTML = TreeMe.Display.Content.Plain(TreeMe.CurrentTree,target) ;
	}
}