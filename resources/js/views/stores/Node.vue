<template>
  <li class="tree-node">
    <div class="tree-item" :class="levelClass">
      <span
        v-if="node.nodes.length"
        class="fas fa-lg fa-fw fa-caret-right mr-2 expand-control"
        :class="{ 'fa-rotate-90': isOpen }"
        @click="toggle"
      ></span>
      <span v-else class="far fa-fw fa-square mr-2"> </span>
      <span class="flex-fill">{{ node.text }}</span>
      <span>
        <show :item="node" action="show"></show>
        <edit v-if="node.edit" :item="node" action="edit"></edit>
        <delete v-if="node.delete" :item="node" action="delete"></delete>
      </span>
    </div>
    <collapse class="tree" :active="isOpen" tag="ul">
      <node v-for="child in node.nodes" :key="child.id" :node="child" :level="level + 1"></node>
    </collapse>
  </li>
</template>

<script>
import Delete from '../../components/actions/Delete';
import Edit from '../../components/actions/Edit';
import Show from '../../components/actions/Show';
import Node from './Node';

export default {
  name: 'Node',

  components: { Node, Delete, Edit, Show },

  props: {
    node: {
      type: Object,
      required: true
    },
    level: {
      type: Number,
      default: 0
    }
  },

  data() {
    return {
      isOpen: this.level < 2
    };
  },

  computed: {
    levelClass() {
      return `level-${this.level}`;
    }
  },

  methods: {
    toggle() {
      this.isOpen = !this.isOpen;
    }
  }
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
