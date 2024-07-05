export default function UserCard({ user, stats }) {
  return (
    <div className="bg-white shadow-md rounded-lg p-6 mb-6">
      <h2 className="text-2xl font-bold mb-4">{user.name}</h2>
      <p className="mb">Email: {user.email}</p>
      <div className="mt-4">
        <h3 className="text-xl font-semibold mb-2">Stats:</h3>
        <p>Books Read: 10</p>
        <p>Last Borrowed: Naruto</p>
        <p>Total Loans: 12</p>
      </div>
    </div>
  );
}
