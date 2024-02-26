<template>
    <button @click="clickMe()">Press Me</button>
</template>

<script>
export default {
  data() {
    return {
      variableName: 0,
    }
  },
  methods: {
    clickMe() {
      alert("You have clicked the button.");
      console.log("You have clicked the button.");
    },
  },
}
</script>
