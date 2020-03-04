<template>
  <div>
    <h2>Todos</h2>
    <!-- add todo list -->
    <form @submit.prevent="addTodo" class="md-3">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Title" v-model="todo.title" />
        <textarea class="form-control" placeholder="Body" v-model="todo.body"></textarea>
        <button
          type="submit"
          class="btn btn-primary btn-block"
          value="add todo"
        >{{edit? "Update ":"Add "}}My Todo</button>
      </div>
    </form>
    <!-- pagination -->
    <nav aria-label="Page Navigation Example">
      <ul class="pagination">
        <li v-bind:class="[{ disabled:!pagination.prev_page_url }]" class="page-item">
          <a class="page-link" href="#" @click="fetchTodos(pagination.prev_page_url)">previous</a>
        </li>

        <li class="page-item disabled">
          <a
            class="page-link test-dark"
            href="#"
          >{{ pagination.current_page }} of {{ pagination.last_page }}</a>
        </li>

        <li v-bind:class="[{ disabled:!pagination.next_page_url }]" class="page-item">
          <a class="page-link" href="#" @click="fetchTodos(pagination.next_page_url)">next</a>
        </li>
      </ul>
      <form @submit.prevent="searchTodo" class="md-3">
        <!-- search by name -->
        <div class="form-group">
          <input type="text" class="form-control" placeholder="search..." v-model="searchName" />
          <span>
            <button type="submit" class="btn btn-light btn-block" value="add todo">search</button>
          </span>
        </div>
      </form>
      <!-- group by different attributes -->
      <span>
        <button
          type="button"
          class="btn btn-light"
          style="width:200px;"
          value="add todo"
          @click="fetchTodos()"
        >All</button>
      </span>
      <span>
        <button
          type="submit"
          class="btn btn-light"
          style="width:200px;"
          value="add todo"
          @click="fetchNotYetTodos()"
        >Todo</button>
      </span>
      <span>
        <button
          type="submit"
          class="btn btn-light"
          style="width:200px;"
          @click="fetchDoneTodos()"
          value="add todo"
        >Done</button>
      </span>
    </nav>
    <div class="card card-body" v-for="todo in todos" v-bind:key="todo.id">
      <!-- tells us the status -->
      <button v-if="todo.state" class="btn btn-outline-success md-2 disabled">Done</button>
      <button v-else class="btn btn-outline-danger md-2 disabled">Not Yet Done</button>
      <h1>{{todo.title}}</h1>
      <p>{{todo.body}}</p>
      <hr />
       <!-- changes the status by click -->
            <button  v-if="!todo.state" class="btn btn-outline-success md-2 " @click="markAsDone(todo)">Mark as Done</button>
            <button  v-else class="btn btn-outline-danger md-2 " @click="markNotYet(todo)"> Mark as Not Yet Done</button>
      <!-- edit and delete -->
      <button @click="editTodo(todo)" class="btn btn-warning md-2">Edit My Todo</button>
      <button @click="deleteTodo(todo.id)" class="btn btn-danger">Delete My Todo</button>
    </div>
  </div>
</template>
<script>
export default {
  props: ["user_id"],
  data() {
    return {
      status: 0, // 1 = not yet, 2 = done
      todos: [],
      searchName: "",
      todo: {
        id: "",
        user_id: this.user_id,
        state: false,
        title: "",
        body: ""
      },
      todo_id: "",
      pagination: {},
      edit: false
    };
  },
  // after creating fetches data
  created() {
    this.fetchTodos();
  },
  methods: {
    // fetches all data
    fetchTodos(page_url) {
      let vm = this;
      page_url = page_url || `api/todos/${this.user_id}`;
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          this.todos = res.data;
          vm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err));
    },

    // fetches the pagination
    makePagination(meta, links) {
      let pagination = {
        current_page: meta.current_page,
        last_page: meta.last_page,
        next_page_url: links.next,
        prev_page_url: links.prev
      };
      this.pagination = pagination;
    },
    // delete a list
    deleteTodo(id) {
      if (confirm("Are you Sure?")) {
        fetch(`api/todo/${id}`, {
          method: "delete"
        })
          .then(res => res.json())
          .then(data => {
            alert("todo was deleted");
            this.fetchTodos();
          })
          .catch(err => console.log(err));
      }
    },
    // adding and updating
    addTodo() {
      if (this.edit == false) {
        //Add
        fetch("api/todo", {
          method: "post",
          body: JSON.stringify(this.todo),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            this.todo.title = "";
            this.todo.body = "";
            alert("todo Added");
            this.fetchTodos();
          })
          .catch(err => console.log(err));
      } else {
        //Update
        console.log("updates", this.todo);
        fetch("api/todo", {
          method: "put",
          body: JSON.stringify(this.todo),
          headers: {
            "content-type": "application/json"
          }
        })
          .then(res => res.json())
          .then(data => {
            this.todo.title = "";
            this.todo.body = "";
            alert("todo Updated");
            this.fetchTodos();
          })
          .catch(err => console.log(err));
      }
    },
    // editing of todo
    editTodo(todo) {
      console.log("this is the state",todo.state);
      this.edit = true;
      this.todo.id = todo.id;
      this.todo.todo_id = todo.id;
      this.todo.state = todo.state;
      this.todo.title = todo.title;
      this.todo.body = todo.body;
      
    },
    editTodoState(todo) {
      console.log("this is the state",todo.state);
      this.edit = true;
      this.todo.id = todo.id;
      this.todo.todo_id = todo.id;
      this.todo.state = todo.state;
      this.todo.title = todo.title;
      this.todo.body = todo.body;
      this.addTodo();
    },
    // searches todo by name
    searchTodo: function() {
      fetch(`api/todo/search/${this.searchName}`)
        .then(res => res.json())
        .then(res => {
          this.todos = res.data;
          vm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err));
    },
    //fetches all done todos
    fetchDoneTodos(page_url) {
      let vm = this;
      page_url = page_url || `api/todo/search/Done/${this.user_id}`;
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          alert("searching..");
          this.todos = res.data;
          vm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err));
    },
    //fetches all not yet done
    fetchNotYetTodos(page_url) {
      let vm = this;
      page_url = page_url || `api/todo/search/NotYet/${this.user_id}`;
      fetch(page_url)
        .then(res => res.json())
        .then(res => {
          alert("searching..");
          this.todos = res.data;
          vm.makePagination(res.meta, res.links);
        })
        .catch(err => console.log(err));
    },

    //updates the state
    markNotYet(todo) {
      this.edit = true;
      todo.state = false;
      this.editTodoState(todo);
    },

    markAsDone(todo) {
      this.edit = true;
      todo.state = true;
      this.editTodoState(todo);
    }
  }
};
</script>