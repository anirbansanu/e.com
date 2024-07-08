# Product Management System Data Flow Diagram

In this section, we'll visualize the data flow within the Product Management System using Mermaid syntax.

## Vendor Interaction

```mermaid
graph TD

subgraph Vendor
  a[Vendor] --> b(Register)
  b -->|Profile Submission| c{Admin Approval}
  c --> |Rejected| d[Notification: Profile Rejected]
  c --> |Approved| e[Redirect: Vendor Dashboard]
  e -->|Manages Products| f(Product Management)
  
end
f -->|Manages Products| ProductManagementSystem

subgraph ProductManagementSystem
    i[Product Listings] --> j[Product Details]
    i --> k[Product Edit]
    i --> l[Product Delete]
end

