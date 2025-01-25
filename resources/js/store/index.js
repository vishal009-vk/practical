// store/index.js
import { createStore } from 'vuex';
import axios from 'axios';

const store = createStore({
  state: {
    tasks: [],
    userList: [],
  },
  mutations: {
    SET_USER_LIST(state, users) {
      state.userList = users;
    },
    SET_TASKS(state, tasks) {
      state.tasks = tasks;
    },
    ADD_TASK(state, task) {
      state.tasks.push(task);
    },
    UPDATE_TASK(state, updatedTask) {
      const index = state.tasks.findIndex(task => task.id === updatedTask.id);
      if (index !== -1) state.tasks[index] = updatedTask;
    },
  },
  actions: {
    async fetchUserList({ commit }) {
      const { data } = await axios.get('/user-list');
      commit('SET_USER_LIST', data);
    },
    async fetchTasks({ commit }) {
      const { data } = await axios.get('/tasks');
      commit('SET_TASKS', data);
    },
    async createTask({ commit }, task) {
      const { data } = await axios.post('/tasks', task);
      commit('ADD_TASK', data);
      
      return data;
    },
    async updateTask({ commit }, task) {
      const { data } = await axios.put(`/tasks/${task.id}`, task);
      commit('UPDATE_TASK', data);

      return data;
    },
    async deleteTask({ commit }, task) {
        const { data } = await axios.delete(`/tasks/${task}`);
        return data;
    },
  },
});

export default store;
