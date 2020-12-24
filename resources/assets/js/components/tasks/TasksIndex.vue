<template>
  <div>
    <div class="form-group">
      <router-link :to="{name: 'createTask'}" class="btn btn-success">Create new Task</router-link>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">Tasks</div>
      <div class="panel-body">
        <table class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Status</th>
            <th width="150">&nbsp;</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(task, index) in tasks">
            <td>{{ task.id }}</td>
            <td>{{ task.name }}</td>
            <td v-if="task.status == 1">Done</td>
            <td v-else-if="task.status == 0">In the plane</td>
            <td v-else>Empty</td>
            <td>
              <router-link :to="{name: 'editTask', params: {id: task.id}}" class="btn btn-xs btn-default">
                Edit
              </router-link>
              <a href="#"
                 class="btn btn-xs btn-danger"
                 v-on:click="deleteEntry(task.id, index)">
                Delete
              </a>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
const axios = require('axios');
export default {
  data: function () {
    return {
      tasks: []
    }
  },
  mounted() {
    var app = this;
    axios.get('/api/task')
        .then(function (resp) {
          app.tasks = resp.data.data;
        })
        .catch(function (resp) {
          console.log(resp);
          alert("Could not load tasks");
        });
  },
  methods: {
    log(msg){
      console.log(msg);
    },
    deleteEntry(id, index) {
      event.preventDefault();
      if (confirm("Do you really want to delete it?")) {
        var app = this;
        axios.delete('/api/task/' + id)
            .then(function (resp) {
              app.tasks.splice(index, 1);
            })
            .catch(function (resp) {
              alert("Could not delete task");
            });
      }
    }
  }
}
</script>