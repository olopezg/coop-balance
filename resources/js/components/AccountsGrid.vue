<template>
  <section class="grid">
    <b-container fluid>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Cuenta</th>
            <th>Balance</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(account, key) in accounts.data" v-bind:key="key">
            <td>{{account.name}}</td>
            <td>{{account.balance}}</td>
          </tr>
        </tbody>
      </table>
    </b-container>
  </section>
</template>
<script>
export default {
  name: "accounts-grid",
  created() {
    window.axios.get("/accounts").then(response => {
      this.accounts = response;
    });
  },
  data() {
    return {
      accounts: {}
    };
  }
};
</script>
