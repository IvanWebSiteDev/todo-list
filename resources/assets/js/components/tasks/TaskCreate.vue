<template>
  <div>
    <div class="form-group">
      <router-link to="/" class="btn btn-default">Back</router-link>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">Create new Task</div>
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
                <option value="0" selected>In the plane</option>
                <option value="1">Done</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
              <button class="btn btn-success">Create</button>
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
  data: function () {
    return {
      task: {
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
      axios.post('/api/task', newTask)
          .then(function (resp) {
            app.$router.push({path: '/'});
          })
          .catch(function (resp) {
            console.log(resp);
            alert("Could not create your Task");
          });
    }
  }
}
</script>