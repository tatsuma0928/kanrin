<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Title</title>
    <link rel="stylesheet" href="../css/jkanban.min.css" />
    <link
      href="https://fonts.googleapis.com/css?family=Lato"
      rel="stylesheet"
    />

    <style>
      body {
        font-family: "Lato";
        margin: 0;
        padding: 0;
      }

      #myKanban {
        overflow-x: auto;
        padding: 20px 0;
      }

      .success {
        background: #00b961;
      }

      .info {
        background: #2a92bf;
      }

      .warning {
        background: #f4ce46;
      }

      .error {
        background: #fb7d44;
      }
    </style>
  </head>
  <body>
    <div id="myKanban"></div>
    <button id="addDefault">Add "Default" board</button>
    <br />
    <button id="addToDo">Add element in "To Do" Board</button>
    <br />
    <button id="removeElement">Remove "My Task Test"</button>

    <script src="../js/jkanban.js"></script>
    <script>
      var KanbanTest = new jKanban({
        element: "#myKanban",
        gutter: "10px",
        widthBoard: "450px",
        itemHandleOptions:{
          enabled: true,
        },
        click: function(el) {

        },
        dropEl: function(el, target, source, sibling){
  
        },
        buttonClick: function(el, boardId) {

          // create a form to enter element
          var formItem = document.createElement("form");
          formItem.setAttribute("class", "itemform");
          formItem.innerHTML =
            '<div class="form-group"><textarea class="form-control" rows="2" autofocus></textarea></div><div class="form-group"><button type="submit" class="btn btn-primary btn-xs pull-right">Submit</button><button type="button" id="CancelBtn" class="btn btn-default btn-xs pull-right">Cancel</button></div>';

          KanbanTest.addForm(boardId, formItem);
          formItem.addEventListener("submit", function(e) {
            e.preventDefault();
            var text = e.target[0].value;
            KanbanTest.addElement(boardId, {
              title: text
            });
            formItem.parentNode.removeChild(formItem);
          });
          document.getElementById("CancelBtn").onclick = function() {
            formItem.parentNode.removeChild(formItem);
          };
        },
        addItemButton: true,
        boards: [
          {
            id: "_todo",
            title: "To Do",
            class: "info,good",
            dragTo: ["_working"],
            item: [

            ]
          },
          {
            id: "_working",
            title: "Working ",
            class: "warning",
            item: [
        
            ]
          },
          {
            id: "_done",
            title: "Done ",
            class: "success",
            dragTo: ["_working"],
            item: [
              
            ]
          }
        ]
      });

      var toDoButton = document.getElementById("addToDo");
      toDoButton.addEventListener("click", function() {
        KanbanTest.addElement("_todo", {
          title: "Test Add"
        });
      });

      var addBoardDefault = document.getElementById("addDefault");
      addBoardDefault.addEventListener("click", function() {
        KanbanTest.addBoards([
          {
            id: "_default",
            title: "Kanban Default",
            item: [
              {
                title: "Default Item"
              },
              {
                title: "Default Item 2"
              },
              {
                title: "Default Item 3"
              }
            ]
          }
        ]);
      });

      var removeBoard = document.getElementById("removeBoard");
      removeBoard.addEventListener("click", function() {
        KanbanTest.removeBoard("_done");
      });

      var removeElement = document.getElementById("removeElement");
      removeElement.addEventListener("click", function() {
        KanbanTest.removeElement("_test_delete");
      });

      var allEle = KanbanTest.getBoardElements("_todo");
      allEle.forEach(function(item, index) {
        //console.log(item);
      });
    </script>
  </body>
</html>
