export default function UserCard({ user, totalLoans, latestBookTitle }) {
  return (
    <div className="bg-white shadow-md rounded-lg p-6 mb-6">
      <h2 className="text-2xl font-bold">{user.name}</h2>
      <p className="mb">{user.email}</p>
      <div className="mt-4">
        <h3 className="text-xl font-semibold mb-2">Stats:</h3>
        <p>Last Book Loaned: {latestBookTitle}</p>
        <p>Total Book Loaned: {totalLoans}</p>
      </div>
    </div>
  );
}
