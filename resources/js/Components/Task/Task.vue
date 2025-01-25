<template>
  <div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Vue Task component</h1>

      <button
        class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"
        data-toggle="modal"
        data-target="#createOrUpdateTask"
      >
        <i class="fas fa-plus fa-sm text-white-50"></i>
        Add Task
      </button>
    </div>

    <div class="card mb-4">
      <div class="card-header">
        <i class="fas fa-tasks me-1"></i>
        Task List
      </div>
      <div class="card-body">
        <table id="taskDataTable">
          <thead>
            <tr>
              <th>Title</th>
              <th>User</th>
              <th>Status</th>
              <th>Total completed task</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(task, index) in tasks" :key="index">
              <td>{{ task.title }}</td>
              <td>{{ task.user.first_name }} {{ task.user.last_name }}</td>
              <td>{{ task.status }}</td>
              <td>1</td>
              <td>
                <button
                  class="btn btn-success mr-2"
                  data-toggle="modal"
                  data-target="#createOrUpdateTask"
                  @click="editTaskItem(task)"
                >
                  Edit
                </button>
                <button class="btn btn-danger" @click="deleteTaskItem(task.unique_id)">
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <div
      class="modal fade"
      id="createOrUpdateTask"
      tabindex="-1"
      role="dialog"
      aria-labelledby="createOrUpdateTaskModal"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="createOrUpdateTaskModal">Task</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <label>Title</label>
                <input type="text" class="form-control" v-model="taskData.title" />
              </div>

              <div class="col-md-12">
                <label>User</label>
                <select class="form-control" v-model="taskData.user">
                  <option value="">Select user</option>
                  <option
                    v-for="(user, index) in userList"
                    :key="index"
                    :value="user.id"
                    :selected="taskData.user.id == user.id"
                  >
                    {{ user.first_name }} {{ user.last_name }}
                  </option>
                </select>
              </div>

              <div class="col-md-12">
                <label>Status</label>
                <select class="form-control" v-model="taskData.status">
                  <option value="">Select Status</option>
                  <option value="Pending" :selected="taskData.status == 'Pending'">
                    Pending
                  </option>
                  <option
                    value="In Progress"
                    :selected="taskData.status == 'In Progress'"
                  >
                    In Progress
                  </option>
                  <option value="Completed" :selected="taskData.status == 'Completed'">
                    Completed
                  </option>
                </select>
              </div>

              <div class="col-md-12">
                <label>Description</label>
                <textarea
                  rows="6"
                  class="form-control"
                  v-model="taskData.description"
                ></textarea>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              class="btn btn-secondary cancelButton"
              type="button"
              data-dismiss="modal"
            >
              Cancel
            </button>
            <button
              class="btn btn-success"
              type="button"
              @click="isEditTask ? updateTaskDetail() : addTask()"
            >
              Save Task
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";

export default {
  data() {
    return {
      tasksList: [],
      taskData: {
        title: "",
        user: "",
        status: "",
        description: "",
      },
      isEditTask: false,
    };
  },
  computed: {
    ...mapState(["tasks", "userList"]),
  },
  methods: {
    ...mapActions([
      "fetchTasks",
      "createTask",
      "updateTask",
      "deleteTask",
      "fetchUserList",
    ]),

    addTask() {
      this.createTask(this.taskData).then((res) => {
        if (res.status) {
          this.closeModal();
          this.fetchTasks();
          Swal.fire("Success", res.message, "success");
        } else {
          Swal.fire("Error!", res.message, "error");
        }
      });
    },

    editTaskItem(task) {
      this.isEditTask = true;
      this.taskData.id = task.unique_id;
      this.taskData.title = task.title;
      this.taskData.user = task.user.id;
      this.taskData.status = task.status;
      this.taskData.description = task.description;
    },

    updateTaskDetail() {
      this.updateTask(this.taskData).then((res) => {
        if (res.status) {
          this.fetchTasks();
          this.closeModal();
          Swal.fire("Success", res.message, "success");
        } else {
          Swal.fire("Error!", res.message, "error");
        }
      });
    },

    deleteTaskItem(id) {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          this.deleteTask(id)
            .then((res) => {
              if (res.status) {
                let findIndex = this.tasks.findIndex((task) => task.unique_id === id);
                if (findIndex != -1) this.tasks.splice(findIndex, 1);

                Swal.fire("Success", res.message, "success");
              } else {
                Swal.fire("Error!", res.message, "error");
              }
            })
            .catch(() => {
              Swal.fire("Error!", "There was a problem deleting the task.", "error");
            });
        }
      });
    },

    closeModal() {
      this.isEditTask = false;
      this.taskData.id = "";
      this.taskData.title = "";
      this.taskData.user = "";
      this.taskData.status = "";
      this.taskData.description = "";

      $(".cancelButton").click();
    },
  },
  created() {
    this.fetchTasks();
    this.fetchUserList();

    setTimeout(() => {
      const taskDataTable = document.getElementById("taskDataTable");

      if (taskDataTable) {
        new simpleDatatables.DataTable(taskDataTable);
      }
    }, 500);
  },
};
</script>
