import { gql } from 'graphql-request'

export const DeleteEmployeeMutation = gql`
  mutation deleteEmployee($id: String!) {
    deleteEmployee(employee: { id: $id })
  }
`
