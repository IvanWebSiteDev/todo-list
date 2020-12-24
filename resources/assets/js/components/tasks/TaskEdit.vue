<template>
  <div>
    <div class="form-group">
      <router-link to="/" class="btn btn-default">Back</router-link>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">Edit Task</div>
      <div class="panel-body">
        <form v-on:submit="saveForm()">
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Task name</label>
              <input type="text" v-model="task.name" class="form-control">
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <label class="control-label">Task status</label>
              <select v-model="task.status" class="form-control">
                <option value="0">In the plane</option>
                <option value="1">Done</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <button class="btn btn-success">Save</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
const axios = require('axios');
export default {
  mounted() {
    let app = this;
    let id = app.$route.params.id;
    app.taskId = id;
    axios.get('/api/task/' + id)
        .then(function (resp) {
          app.task = resp.data.data;
        })
        .catch(function () {
          alert("Could not load your task")
        });
  },
  data: function () {
    return {
      taskId: null,
      task: {
        id: '',
        name: '',
        status: '',
      }
    }
  },
  methods: {
    saveForm() {
      event.preventDefault();
      var app = this;
      var newTask = app.task;
      axios.patch('/api/task/' + app.taskId, newTask)
          .then(function (resp) {
            app.$router.replace('/');
          })
          .catch(function (resp) {
            console.log(resp);
            alert("Could not create your task");
          });
    }
  }
}
</script>