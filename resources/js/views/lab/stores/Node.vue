<template>
  <li class="tree-node">
    <div class="tree-item" :class="levelClass">
      <span
        v-if="node.nodes.length"
        class="fas fa-lg fa-fw fa-caret-right mr-2 expand-control"
        :class="{ 'fa-rotate-90': isOpen }"
        @click="toggle"
      ></span>
      <span v-else class="fas fa-fw fa-inbox mr-2"> </span>
      <span class="flex-fill">{{ node.name }}</span>
      <span>
        <action-bar :item="node"></action-bar>
      </span>
    </div>
    <collapse class="tree" :active="isOpen" tag="ul">
      <node v-for="child in node.nodes" :key="child.id" :node="child" :level="level + 1"></node>
    </collapse>
  </li>
</template>

<script>
import ActionBar from '../../../components/actions/ActionBar';

export default {
  name: 'Node',

  components: { ActionBar, Node: () => import('./Node.vue') },

  props: {
    node: {
      type: Object,
      required: true,
    },
    level: {
      type: Number,
      default: 0,
    },
  },

  data() {
    return {
      isOpen: this.level < 2,
    };
  },

  computed: {
    levelClass() {
      return `level-${this.level}`;
    },
  },

  methods: {
    toggle() {
      this.isOpen = !this.isOpen;
    },
  },
};
</script>

<style lang="scss">
.tree {
  list-style: none;
  display: flex;
  flex-direction: column;
  padding-left: 0;
  margin-bottom: 0;
}

.tree-node {
  background: white;
}

.tree-item {
  display: flex;
  align-items: center;
  padding: 0.75rem 0.75rem;
  border: 1px solid rgba(17, 17, 17, 0.125);
  margin-bottom: -1px;
}

.expand-control {
  cursor: pointer;
  transition: 0.3s all ease;
}

.level-0 {
  padding-left: 0.75rem;
}

.level-1 {
  padding-left: 1.5rem;
}

.level-2 {
  padding-left: 2.25rem;
}

.level-3 {
  padding-left: 3rem;
}

.level-4 {
  padding-left: 3.75rem;
}

.level-5 {
  padding-left: 4.5rem;
}
</style>
